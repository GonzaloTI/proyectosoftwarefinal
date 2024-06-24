<!-- resources/views/diagnosticos/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Crear Nuevo Diagnóstico</h1>
        <form method="POST" action="{{ route('diagnosticos.store') }}">
            @csrf
            <div class="form-group">
                <label for="ci">CI:</label>
                <input type="number" class="form-control" id="ci" name="ci" placeholder="Número de CI" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <label for="a_paterno">Apellido Paterno:</label>
                <input type="text" class="form-control" id="a_paterno" name="a_paterno" placeholder="Apellido Paterno" required>
            </div>
            <div class="form-group">
                <label for="a_materno">Apellido Materno:</label>
                <input type="text" class="form-control" id="a_materno" name="a_materno" placeholder="Apellido Materno" required>
            </div>
            
            <button  type="submit" class="btn btn-primary">Solicitar Diagnóstico</button>
            <a href="{{ route('recomendacion.index') }}" class="btn btn-primary">Ver lista</a>
        </form>
    </div>
@endsection
