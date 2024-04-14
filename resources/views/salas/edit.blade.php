@extends('layouts.app')
@section("content")
<form method="POST" action="{{ route('salas.update', $id) }}" class="mt-3">
    @csrf
    {{ method_field('PUT') }}
    <h3>Editar la sala</h3>
    @error('nombre')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="inputSala" class="col-form-label">Nombre de la sala</label>
        </div>
        <div class="col-auto">
            <input type="test" name="nombre" id="inputSala" class="form-control" value="{{$nombre}}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Editar</button>
        </div>
    </div>
</form>
@endsection