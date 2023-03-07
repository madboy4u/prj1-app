<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        Elenco proprietari
        </h2>
    </x-slot>

    <div class="row mt-3 text-center">
        <a href="/inserisciproprietario"><i class="fa-solid fa-circle-plus"></i></a>
    </div>
    
    <div class="container mt-3">
        <div class="row">
            <label class="col-2"></label>
            <label class="col-3">Codice Fiscale</label>
            <label class="col-3">Cognome Nome</label>
        </div>
        <bR>
        @foreach($proprietar as $proprietario)
            <div class="row">
                <label class="col-2"></label>
                <label class="col-3">{{ $proprietario->codicefiscale }}</label>
                <label class="col-3">{{ $proprietario->cognome }} {{ $proprietario->nome }}</label>
                <label class="col-1">
                    <a href="/modificaproprietario/{{$proprietario->codicefiscale}}"><i class="fa-solid fa-pen"></i></a>
                </label>
                <label class="col-1">
                    <a href="/cancellaproprietario/{{$proprietario->codicefiscale}}" onclick="return confirm('Sei sicuro di voler cancellare {{ $proprietario->cognome }} {{ $proprietario->nome }} ?')"><i class="fa-solid fa-circle-minus"></i></a>
                </label>
            </div>
        @endforeach
    </div>

</x-app-layout>