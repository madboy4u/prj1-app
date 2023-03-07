<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Modelc;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;


class CarController extends Controller
{


    public function inseriscicolore()
    {
        $colore = new Color;
        $colore->id = 0;
        $colore->color = "";

        $titolo = "Inserisci un nuovo colore";

        return view('colore', compact('colore', 'titolo'));
    }
    

    public function storecolore(Request $request)
    {

        $this->validate($request, ['colore' => 'required|unique:colors,color'],
        [
            'colore.required' => 'Ricordati di inserire il colore',
            'colore.unique' => 'Specifica un colore inesistente'
        ]);

        if($request->id > 0)
        {
            // modifica
            $color = Color::find($request->id);
        }
        else
        {
            $color = new Color;
        }
        $color->color = $request->colore;
        $color->save();

        return $this->listacolori();
    }

    public function listacolori()
    {
        $colori = Color::orderBy('color')->get();

        return view('colori', compact('colori'));
        
    }

    public function modificacolore($idcolore)
    {
        
        $colore = Color::find($idcolore);

        $titolo = "Modifica il colore " . $colore->color;

        return view('colore', compact('colore', 'titolo'));
    }
    
    public function cancellacolore($idcolore)
    {
        
        
        Color::find($idcolore)->delete();

        return $this->listacolori();
    }

    public function inseriscimarchio()
    {
        $marchio = new Brand;
        $marchio->id = 0;
        $marchio->brand = "";

        $titolo = "Inserisci un nuovo marchio";

        return view('marchio', compact('marchio', 'titolo'));
    }
    

    public function storemarchio(Request $request)
    {

        $this->validate($request, ['marchio' => 'required|unique:brands,brand'],
        [
            'marchio.required' => 'Ricordati di inserire il marchio',
            'marchio.unique' => 'Specifica un marchio inesistente'
        ]);

        if($request->id > 0)
        {
            // modifica
            $brand = Brand::find($request->id);
        }
        else
        {
            $brand = new Brand;
        }
        $brand->brand = $request->marchio;
        $brand->save();

        return $this->listamarchi(0);
    }

    public function listamarchi($errore = 0)
    {
        $marchi = Brand::orderBy('brand')->get();

        return view('marchi', compact('marchi', 'errore'));
        
    }

    public function modificamarchio($idmarchio)
    {
        
        $marchio = Brand::find($idmarchio);

        $titolo = "Modifica il marchio " . $marchio->brand;

        return view('marchio', compact('marchio', 'titolo'));
    }
    
    public function cancellamarchio($idmarchio)
    {
        $errore = 0;
        try{
            Brand::find($idmarchio)->delete();
        }
        catch(QueryException $e) {
            $errore = 1;
        }
        

        return $this->listamarchi($errore);
    }

    public function listamodelli()
    {

        $modelli = DB::table('models')
        ->leftjoin('brands', 'models.brand_id', '=', 'brands.id')
        ->select('models.*', 'brands.brand')
        ->orderBy('model')
        ->get();
        /*
        $istruzione = 'select m.id, m.brand_id, m.model, b.brand ' . 
        'from models m left join brands b on m.brand_id = b.id order by m.model;';
        
        $modelli = DB::select($istruzione);
        */
        //dd($modelli);

        return view('modelli', compact('modelli'));
        
    }
    
    public function inseriscimodello()
    {
        $modello = new Modelc;
        $modello->id = 0;
        $modello->brand_id = 0;
        $modello->model = "";

        $marchi = Brand::orderBy('brand')->get();

        $titolo = "Inserisci un nuovo modello";

        return view('modello', compact('modello', 'titolo', 'marchi'));
    }
        

    public function storemodello(Request $request)
    {

        $this->validate($request, ['modello' => 'required|unique:models,model'],
        [
            'modello.required' => 'Ricordati di inserire il modello',
            'modello.unique' => 'Specifica un modello inesistente'
        ]);

        if($request->id > 0)
        {
            // modifica
            $modello = Modelc::find($request->id);
        }
        else
        {
            $modello = new Modelc;
        }
        $modello->model = $request->modello;
        $modello->brand_id = $request->marchioid;
        $modello->save();

        return $this->listamodelli();
    }

    
    public function modificamodello($idmodello)
    {
        
        $modello = Modelc::find($idmodello);
        
        $marchi = Brand::orderBy('brand')->get();

        $titolo = "Modifica il modello " . $modello->model;

        return view('modello', compact('modello', 'titolo', 'marchi'));
    }
        
    public function cancellamodello($idmodello)
    {
        
        Modelc::find($idmodello)->delete();

        return $this->listamodelli();
    }

    
    public function listaautomobili()
    {

        $automobili = DB::table('cars')
        ->leftjoin('brands', 'cars.brand_id', '=', 'brands.id')
        ->leftjoin('colors', 'cars.color_id', '=', 'colors.id')
        ->leftjoin('models', 'cars.model_id', '=', 'models.id')
        ->select('cars.*', 'brands.brand', 'colors.color', 'models.model')
        ->orderBy('targa')
        ->get();
        
        /*
        $istruzione = 'select m.id, m.brand_id, m.model, b.brand ' . 
        'from models m left join brands b on m.brand_id = b.id order by m.model;';
        
        $modelli = DB::select($istruzione);
        */
        //dd($modelli);

        return view('automobili', compact('automobili'));
        
    }
        
    public function inserisciautomobile()
    {
        $automobile = new Car;
        //$automobile->targa = "";
        $automobile->brand_id = 0;
        $automobile->model_id = 0;
        $automobile->color_id = 0;
        //dd($automobile);

        $marchi = Brand::orderBy('brand')->get();
        $modelli = DB::table('models')
        ->leftjoin('brands', 'models.brand_id', '=', 'brands.id')
        ->select('models.*', 'brands.brand')
        ->orderBy('brand','asc')
        ->orderBy('model','asc')
        ->get();
        $colori = Color::orderBy('color')->get();

        $titolo = "Inserisci una nuova automobile";

        return view('automobile', compact('automobile', 'titolo', 'marchi', 'modelli', 'colori'));
    }

    
    
    public function modificaautomobile($idautomobile)
    {
        
        $marchi = Brand::orderBy('brand')->get();
        $modelli = DB::table('models')
        ->leftjoin('brands', 'models.brand_id', '=', 'brands.id')
        ->select('models.*', 'brands.brand')
        ->orderBy('brand','asc')
        ->orderBy('model','asc')
        ->get();
        $colori = Color::orderBy('color')->get();

        $automobile = DB::table('cars')
        ->where('cars.targa','=',$idautomobile)
        ->first();
        //dd($automobile);

        $titolo = "Modifica l'auto con targa " . $automobile->targa;

        return view('automobile', compact('automobile', 'titolo', 'marchi', 'modelli', 'colori'));
    }
                

    public function storenewautomobile(Request $request)
    {

        
        $this->validate($request, ['targa' => 'required|regex:/^[A-Z]{2}\d{3}[A-Z]{2}$/i',
        'modelloid' => 'required|regex:/^[1-9][0-9]*$/',
        'coloreid' => 'required|regex:/^[1-9][0-9]*$/'],
        [
            'targa.required' => 'Ricordati di inserire la targa',
            'targa.regex' => 'La targa deve avere 2 lettere, 3 numeri e 2 lettere',
            'modelloid.required' => 'Ricordati di scegliere un modello e narchio',
            'coloreid.required' => 'Ricordati di scegliere il colore',
            'modelloid.regex' => 'Ricordati di scegliere un modello e narchio',
            'coloreid.regex' => 'Ricordati di scegliere il colore',
        ]);
        //dd($request);

        $this->validate($request, ['targa' => 'unique:cars'],
        [
            'targa.unique' => 'Questa targa è già stata inserita'
        ]);

        $automobile = new Car;
        $automobile->targa = $request->targa;

        
        $modello = Modelc::find($request->modelloid);
        

        $automobile->model_id = $request->modelloid;
        $automobile->color_id = $request->coloreid;
        $automobile->brand_id = $modello->brand_id;

        //dd($request,$automobile, $modello);
        //dd($automobile,$request);
        $automobile->save();

        return $this->listaautomobili();
    }
            

    public function storeautomobile(Request $request)
    {

        
        $this->validate($request, ['targa' => 'required|regex:/^[A-Z]{2}\d{3}[A-Z]{2}$/i',
        'modelloid' => 'required|regex:/^[1-9][0-9]*$/',
        'coloreid' => 'required|regex:/^[1-9][0-9]*$/'],
        [
            'targa.required' => 'Ricordati di inserire la targa',
            'targa.regex' => 'La targa deve avere 2 lettere, 3 numeri e 2 lettere',
            'modelloid.required' => 'Ricordati di scegliere un modello e narchio',
            'coloreid.required' => 'Ricordati di scegliere il colore',
            'modelloid.regex' => 'Ricordati di scegliere un modello e narchio',
            'coloreid.regex' => 'Ricordati di scegliere il colore',
        ]);
        //dd($request);


        
        $modello = Modelc::find($request->modelloid);

        Car::where('targa', '=', $request->targa)
        ->update(['model_id' => $request->modelloid,
                'color_id' => $request->coloreid,
                'brand_id' => $modello->brand_id]);

        return $this->listaautomobili();
    }

            
    public function cancellaautomobile($idautomobile)
    {
        
        Car::where('targa', '=', $idautomobile)
        ->delete();

        return $this->listaautomobili();
    }

    public function listaproprietari($errore = 0)
    {
        $proprietar = DB::table('owners')
        ->orderBy('cognome')
        ->get();

        return view('proprietari', compact('proprietar', 'errore'));
        
    }
    
    public function inserisciproprietario()
    {
        $proprietario = new Owner;
        //$proprietario->codicefiscale = "";
        $proprietario->nome = "";
        $proprietario->cognome = "";

        $titolo = "Inserisci un nuovo proprietario";

        return view('proprietario', compact('proprietario', 'titolo'));
    }
                    

    public function storenewproprietario(Request $request)
    {

        
        $this->validate($request, ['codicefiscale' => 'required|regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i',
        'nome' => 'required|regex:/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/i',
        'cognome' => 'required|regex:/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/i'],
        [
            'codicefiscale.required' => 'Ricordati di inserire il codice fiscale',
            'codicefiscale.regex' => 'Codice fiscale non corretto',
            'nome.required' => 'Ricordati di inserire il nome',
            'cognome.required' => 'Ricordati di inserire il cognome',
            'cognome.regex' => 'Cognome non valido',
            'nome.regex' => 'Nome non valido',
        ]);
        //dd($request);

        $this->validate($request, ['codicefiscale' => 'unique:owners'],
        [
            'codicefiscale.unique' => 'Questo codice fiscale è già presente in archivio'
        ]);

        $proprietario = new Owner;
        $proprietario->codicefiscale = $request->codicefiscale;
        
        $proprietario->nome = $request->nome;
        $proprietario->cognome = $request->cognome;

        //dd($request,$automobile, $modello);
        //dd($automobile,$request);
        $proprietario->save();

        return $this->listaproprietari();
    }
        
    
    public function modificaproprietario($idproprietario)
    {
        

        $proprietario = DB::table('owners')
        ->where('owners.codicefiscale','=',$idproprietario)
        ->first();
        //dd($automobile);

        $titolo = "Modifica i dati del proprietario " . $proprietario->codicefiscale;

        return view('proprietario', compact('proprietario', 'titolo'));
    }
                        

    public function storeproprietario(Request $request)
    {

        
        $this->validate($request, ['nome' => 'required|regex:/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/i',
        'cognome' => 'required|regex:/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/i'],
        [
            'nome.required' => 'Ricordati di inserire il nome',
            'cognome.required' => 'Ricordati di inserire il cognome',
            'cognome.regex' => 'Cognome non valido',
            'nome.regex' => 'Nome non valido',
        ]);

        Owner::where('codicefiscale', '=', $request->id)
        ->update(['nome' => $request->nome,
                'cognome' => $request->cognome]);

        return $this->listaproprietari();
    }

    
    public function listaproprieta($errore = 0)
    {
        $proprieta = DB::table('car_owner')
        ->leftjoin('cars', 'car_owner.car_id', '=', 'cars.targa')
        ->leftjoin('owners', 'car_owner.owner_id', '=', 'owners.codicefiscale')
        ->orderBy('owners.codicefiscale')
        ->get();

        //dd($proprieta);

        return view('proprieta', compact('proprieta', 'errore'));
        
    }
    
    
    public function inserisciproprieta()
    {
        $proprieta = DB::table('car_owner')
        ->leftjoin('cars', 'car_owner.car_id', '=', 'cars.targa')
        ->leftjoin('owners', 'car_owner.owner_id', '=', 'owners.codicefiscale')
        ->leftjoin('models', 'models.id', '=', 'cars.model_id')
        ->leftjoin('brands', 'brands.id', '=', 'cars.brand_id')
        ->where('car_owner.data_vendita','=', '0000-00-00')
        ->orderBy('owners.codicefiscale')
        ->get();

        $acquirenti = DB::table('owners')->orderBy('nome')->get();
        //dd($acquirenti[0]->codicefiscale);
        $titolo = 'Inserisci la proprietà';

        

        return view('inserisciproprieta', compact('proprieta', 'acquirenti','titolo'));
        
    }


    public function storeproprieta(Request $request)
    {
        $this->validate($request, ['autoid' => 'required|regex:/[^0]/',
        'acquid' => 'required|regex:/[^0]/'],
        [
            'autoid.required' => 'Ricordati di selezionare l\'auto',
            'autoid.regex' => 'Ricordati di selezionare l\'auto',
            'acquid.required' => 'Ricordati di selezionare l\'acquirente',
            'acquid.regex' => 'Ricordati di selezionare l\'acquirente'
        ]);

        $targa = substr($request->autoid, 0, 7);
        $cf_venditore = substr($request->autoid, 9);
        dd($targa, $cf_venditore);

        // aggiornamento record venditore

    }
}
