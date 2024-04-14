@extends('layouts.app')
@section("content")
<form method="POST" action="{{ route('salas.store') }}" class="mt-3">
    @csrf
    <h3>Crear nueva sala</h3>
    @error('nombre')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="inputSala" class="col-form-label">Nombre dela sala</label>
        </div>
        <div class="col-auto">
            <input type="test" name="nombre" id="inputSala" class="form-control">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Crear</button>
        </div>
    </div>
</form>
@endsection