<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        Elenco modelli
        </h2>
    </x-slot>
    <div class="row mt-3 text-center">
    <a href="/inseriscimodello"><i class="fa-solid fa-circle-plus"></i></a>
    </div>

    <div class="container mt-3">
        @foreach($modelli as $modello)
            <div class="row">
                <label class="col-4"></label>
                <label class="col-3">{{ $modello->model }}</label>
                <label class="col-1">{{ $modello->brand }}</label>
                <label class="col-1">
                    <a href="/modificamodello/{{$modello->id}}"><i class="fa-solid fa-pen"></i></a>
                    <a href="/cancellamodello/{{$modello->id}}" onclick="return confirm('Sei sicuro di voler cancellare {{ $modello->model }} ?')"><i class="fa-solid fa-circle-minus"></i></a>
                </label>
            </div>
        @endforeach
    </div>

</x-app-layout>