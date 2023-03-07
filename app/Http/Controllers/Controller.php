<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function pluto(Request $request)
    {
        $nome = $request->nome;
        $email = $request->email;
        $testo = 'Ciao, io sono il tuo primo controller';
        return view('pluto', compact('testo', 'nome', 'email'));
    }


    public function prova()
    {
        $messaggio = 'Messaggio ricevuto da: ';
        $nome = "";
        $email = "";
        $telefono = "";
        $textarea = "";
        return view('/contatti', compact('messaggio', 'nome', 'email', 'telefono', 'textarea'));
    }


    public function link(Request $request)
    {
        session(['nome' => $request->nome, 'telefono' => $request->telefono,
        'mail' => $request->email, 'messaggio' => $request->textarea]);

        $messaggio = 'Messaggio ricevuto da: ';
        $nome = $request->nome;
        $email = $request->email;
        $telefono = $request->telefono;
        $textarea = $request->textarea;
        return view('link', compact('messaggio', 'nome', 'email', 'telefono', 'textarea'));
    }


    public function contattiricevuti(Request $request)
    {
        $nome = $request->nome;
        $email = $request->email;
        $telefono = $request->telefono;
        $textarea = $request->textarea;
        return view('contatti', compact('nome', 'email', 'telefono', 'textarea'));
    }
}
 