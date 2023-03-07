@extends('shared.header')

@section('content')
    <h2 class="text-center">{{$titolo}}</h2>
    <div class="container mt-3">
        @if( strlen($automobile->targa) > 6 )
            <form action="{{ url('automobile') }}" method="POST">
        @else
            <form action="{{ url('automobilenew') }}" method="POST">
        @endif
        @csrf
        <input style="display:none" type="text" name="id" value="{{$automobile->targa}}" readonly> <br>
        <div class="row">
            <div class="col-4"></div>
            <label for="automobile" class="col-1 col-form-label">Automobile</label>
            <div class="col-3">
                <input type="text" name="targa" 
                class="form-control @error('targa') is-invalid @enderror" 
                value="{{ old('targa') ?? $automobile->targa}}" 
                {{ ( strlen($automobile->targa) > 6 ) ? 'readonly' : ''}}> <br>
            </div>
        </div>
        <div class="row">
        <div class="col-4"></div>
            <label for="modello" class="col-1 col-form-label">Modello</label>
            <div class="col-3">
                <select name="modelloid" class="form-control">
                    <option value="0" selected>Selezionare...</option>
                    @foreach($modelli as $modello)
                        <option value="{{$modello->id}}" {{ ( (old('modelloid') ?? $automobile->model_id) == $modello->id) ? 'selected' : ''}}>
                            {{$modello->brand}} - {{$modello->model}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
        <div class="col-4"></div>
            <label for="colore" class="col-1 col-form-label">Colore</label>
            <div class="col-3">
                <select name="coloreid" class="form-control">
                    <option value="0" selected>Selezionare...</option>
                    @foreach($colori as $colore)
                        <option value="{{$colore->id}}" {{ ( (old('coloreid') ?? $automobile->color_id) == $colore->id) ? 'selected' : ''}}>{{$colore->color}}</option>
                    @endforeach
                </select>
            </div>
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
        <input class="mt-3" type="submit" value="Salva">
        <a class="btn btn-danger" href="{{ url('automobili') }}">Annulla</a>
        </div>
        </form>
    </div>
    

@endsection