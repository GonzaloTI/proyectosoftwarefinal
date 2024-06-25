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
                            data-resultado-diagnostico-ia="{{ $diagnostico->resultado_ia }}"
                            data-resultado-diagnostico="{{ $diagnostico->resultado }}"
                            data-imagenes="{{ $diagnostico->ecografias->pluck('path')->implode(',') }}">
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
            <label for="recomenda">Resultado de la IA:</label>
            <textarea class="form-control" id="recomenda" name="recomenda" readonly></textarea>
        </div>
        <div class="form-group">
            <label for="resultado">Resultado:</label>
            <input type="text" class="form-control" id="resultado" name="resultado" value="">
        </div>
        <div class="form-group">
            <label for="imagenes">Imágenes:</label>
            <div id="imagenes" class="d-flex flex-wrap"></div>
        </div>

        <div class="form-group">
            <label for="recomendacion">Recomendación:</label>
            <textarea class="form-control" id="recomendacion" name="recomendacion" rows="5" required></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enviar recomendación</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const diagnosticoSelect = document.getElementById('diagnostico_id');
        const nombreClienteInput = document.getElementById('nombre');
        const resultadosInput = document.getElementById('recomenda');
        const resultadosDiagnosticoInput = document.getElementById('resultado');
        const imagenesContainer = document.getElementById('imagenes');

        diagnosticoSelect.addEventListener('change', function () {
            const selectedOption = diagnosticoSelect.options[diagnosticoSelect.selectedIndex];
            const nombreCliente = selectedOption.getAttribute('data-nombre-cliente');
            const resultados = selectedOption.getAttribute('data-resultado-diagnostico-ia');
            const resultadoDiag = selectedOption.getAttribute('data-resultado-diagnostico');
            const imagenes = selectedOption.getAttribute('data-imagenes').split(',');

            nombreClienteInput.value = nombreCliente;
            resultadosInput.value = resultados;
            resultadosDiagnosticoInput.value = resultadoDiag;
            // Limpiar contenedor de imágenes
            imagenesContainer.innerHTML = '';
            // Mostrar imágenes
            imagenes.forEach(function (url) {
                if (url.trim() !== '') {
                    const img = document.createElement('img');
                    img.src = url.trim();
                    img.alt = 'Ecografía';
                    img.className = 'img-thumbnail m-2';
                    img.style.maxWidth = '250px';
                    img.style.height = 'auto';
                    imagenesContainer.appendChild(img);
                }
            });
        });

        // Trigger change event to set initial value
        diagnosticoSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
