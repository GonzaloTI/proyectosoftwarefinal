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
            <option value="{{ $diagnostico->id }}" 
             data-nombre-cliente="{{ $diagnostico->cliente->name }}" 
             
             data-resultado-diagnostico-ia="{{ $diagnostico->resultado }}">
                {{ $diagnostico->id }} 
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="nombre">Nombre Cliente:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" readonly>
</div>
<div class="form-group">
    <label for="resultado">Resultados:</label>
    <textarea type="text" class="form-control" id="resultado" name="resultado" readonly></textarea>
</div>
<!-- <div class="form-group">
    <label for="resultado_ia">Resultado IA:</label>
    <input type="text" class="form-control" id="resultado_ia" name="resultado_ia" readonly>
</div> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const diagnosticoSelect = document.getElementById('diagnostico_id');
        //const resultadoIaInput = document.getElementById('resultado_ia');
        const nombreClienteInput = document.getElementById('nombre');
        const ResultadosInput = document.getElementById('resultado');
        diagnosticoSelect.addEventListener('change', function () {
            const selectedOption = diagnosticoSelect.options[diagnosticoSelect.selectedIndex];
           // const resultadoIa = selectedOption.getAttribute('data-resultado-ia');
            const nombreCliente = selectedOption.getAttribute('data-nombre-cliente');
            const Resultados = selectedOption.getAttribute('data-resultado-diagnostico-ia');
           // resultadoIaInput.value = resultadoIa;
            nombreClienteInput.value = nombreCliente;
            ResultadosInput.value=Resultados;
        });

        // Trigger change event to set initial value
        diagnosticoSelect.dispatchEvent(new Event('change'));
    });
</script>




        <div class="form-group">
            <label for="recomendacion">Recomendación:</label>
            <textarea class="form-control" id="recomendacion" name="recomendacion" rows="5" required></textarea>
        </div>

        <div class="text-center">
                <button  type="submit" class="btn btn-primary">Enviar recomendación</button>
        </div>
        <!-- <a href="{{ route('medico.index') }}" class="btn btn-primary">Volver</a> -->
    </form>
</div>
@endsection
