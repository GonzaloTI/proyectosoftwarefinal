<!-- resources/views/recomendacion/create.blade.php -->
@extends('layouts.app')

@section('title', 'Crear Recomendación')

@section('content')
<div class="container">
    <h1 class="text-center" style="font-weight: bold;">Crear Recomendación</h1>

    <form action="{{ route('recomendacion.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="diagnostico_id">Seleccionar Diagnóstico:</label>
            <select class="form-control" id="diagnostico_id" name="diagnostico_id" required>
                @foreach ($diagnosticos as $diagnostico)
                    <option value="{{ $diagnostico->id }}">{{ $diagnostico->id }} - {{ $diagnostico->nombre }} {{ $diagnostico->a_paterno }} {{ $diagnostico->a_materno }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="recomendacion">Recomendación:</label>
            <textarea class="form-control" id="recomendacion" name="recomendacion" rows="5" required></textarea>
        </div>

        <div class="text-center">
                <button  type="submit" class="btn btn-primary">Enviar recomendación</button>
        </div>
        <a href="{{ route('medico.index') }}" class="btn btn-primary">Volver</a>
    </form>
</div>
@endsection
