<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        {{$titolo}}

    </h2>
    </x-slot>
    <div class="container mt-3">
        <form action="{{ url('storeproprieta') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-3"></div>
            <label for="autoid" class="col-1 col-form-label">Automobile</label>
            <div class="col-4">
                <select name="autoid" id="autoid" class="form-control" onblur="controlla(1)" onchange="controlla(1)">
                    <option value="0" selected>Selezionare...</option>
                    @foreach($proprieta as $proprie)
                        <option value="{{$proprie->targa}}-{{$proprie->codicefiscale}}" 
                        {{ (($proprie->targa . "-" . $proprie->codicefiscale) == old('autoid')) ? 'selected' : ''}}>
                            {{$proprie->targa}} - {{$proprie->model}} - {{$proprie->brand}} - {{$proprie->nome}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <label for="acquid" class="col-1 col-form-label">Acquirente</label>
            <div class="col-4">
                <select name="acquid" id="acquid" class="form-control" onblur="controlla(0)" onchange="controlla(0)">
                    <option value="0" selected>Selezionare...</option>
                    @foreach($acquirenti as $acquirente)
                        <option value="{{$acquirente->codicefiscale}}" 
                        {{ ($acquirente->codicefiscale == old('acquid')) ? 'selected' : ''}}>
                            {{$acquirente->nome}} {{$acquirente->cognome}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <label for="dataacquisto" class="col-1 col-form-label">Data</label>
            <div class="col-4">
                <input type="date" name="datavendita" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}">
            </div>
        </div>
        <div class="row">
            <div class="col-4"></div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="text-center">
        <input id="idsalva" class="mt-3" type="submit" value="Salva">
        <a class="btn btn-danger" href="{{ url('proprieta') }}">Annulla</a>
        </div>
        </form>
    </div>
<script>
    function controlla(auto)
    {
        cf_acquirente = $('#acquid option:selected').val();
        cf_venditore = $('#autoid option:selected').val().substring(8);
        console.log("---",cf_acquirente,cf_venditore,"---",!cf_acquirente.localeCompare(cf_venditore));
        
        $('#idsalva').prop('disabled', false);

        if(!cf_acquirente.localeCompare(cf_venditore))
        {
            if(auto)
                $('#autoid').prop('selectedIndex',0);
            else
                $('#acquid').prop('selectedIndex',0);

            alert('Non è possibile scegliere lo stesso acquirente/venditore')
            $('#idsalva').prop('disabled', true);
        }
        
    }
</script>

</x-app-layout>