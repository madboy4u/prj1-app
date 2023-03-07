<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        Elenco automobili
        </h2>
    </x-slot>
    <div class="row mt-3 text-center">
    <a href="/inserisciautomobile"><i class="fa-solid fa-circle-plus"></i></a>
    </div>

    <div class="container mt-3">
        <div class="row">
            <label class="col-2"></label>
            <label class="col-1">Targa</label>
            <label class="col-2">Modello</label>
            <label class="col-2">Marchio</label>
            <label class="col-2">Colore</label>
        </div><br>
        @foreach($automobili as $automobile)
            <div class="row">
                <label class="col-2"></label>
                <label class="col-1">{{ $automobile->targa }}</label>
                <label class="col-2">{{ $automobile->model }}</label>
                <label class="col-2">{{ $automobile->brand }}</label>
                <label class="col-2">{{ $automobile->color }}</label>
                <label class="col-1">
                    <a href="/modificaautomobile/{{$automobile->targa}}"><i class="fa-solid fa-pen"></i></a>
                </label>
                <label class="col-1">
                    <a href="/cancellaautomobile/{{$automobile->targa}}" onclick="return confirm('Sei sicuro di voler cancellare {{ $automobile->targa }} ?')"><i class="fa-solid fa-circle-minus"></i></a>
                </label>
            </div>
        @endforeach
    </div>

</x-app-layout>