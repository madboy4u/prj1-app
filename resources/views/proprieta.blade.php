<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
        Elenco proprietà
        </h2>
    </x-slot>

    <div class="row mt-3 text-center">
        <a href="/inserisciproprieta"><i class="fa-solid fa-circle-plus"></i></a>
    </div>
    
    <div class="container mt-3">
        <div class="row">
            <label class="col-2"></label>
            <label class="col-2">Targa</label>
            <label class="col-2">Codice Fiscale</label>
            <label class="col-2">Data Acquisto</label>
            <label class="col-2">Data Vendita</label>
        </div>
        <bR>
        @foreach($proprieta as $proprie)
            <div class="row">
                <label class="col-2"></label>
                <label class="col-2">{{ $proprie->targa }}</label>
                <label class="col-2">{{ $proprie->codicefiscale }}</label>
                @if($proprie->data_acquisto <> "0000-00-00")
                    <label class="col-2">{{ date_create_from_format('Y-m-d', $proprie->data_acquisto)->format('d-m-Y') }}</label>
                @endif
                @if($proprie->data_vendita <> "0000-00-00")
                    <label class="col-2">{{ date_create_from_format('Y-m-d', $proprie->data_vendita)->format('d-m-Y') }}</label>
                @endif
            </div>
        @endforeach
    </div>

</x-app-layout>