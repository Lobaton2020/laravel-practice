@extends('layouts.app')
@section("content")
<div>
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif
    @if(!$salas->isEmpty())
    <div><a class="btn btn-primary float-left" href="{{ url("/salas/create") }}">Crear sala</a></div>
    @endif
    <div class="row">
        @foreach($salas as $sala)
        <div class="col-md-4 p-1">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sala->nombre }}</h5>
                    </div>
                    <div class="dropdown mr-1">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url("/salas/$sala->id/edit") }}">Editar</a></li>
                            <li>
                                <form method="POST" action="{{ route('salas.destroy', $sala->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item" type="submit" onclick="return confirm('Estas seguro?')">Eliminar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($salas->isEmpty())
    <h1>No hay Salas, Añade una nueva <a href="{{ url("/salas/create") }}">aqui</a></h1>
    @endif

</div>

@endsection