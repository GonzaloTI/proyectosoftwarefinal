@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center" style="font-weight: bold;" class="mb-4">Historial medico</h1>

    @if ($diagnosticos->isEmpty())
    <div class="alert alert-info mt-4" role="alert">
        No se encontraron diagnósticos en el historial.
    </div>
    @else
    <div class="list-group">
        @foreach ($diagnosticos as $diagnostico)
        <div class="list-group-item mb-3 p-4 shadow-sm">
            <div class="mb-3">
                <label for="resultado-ia-{{ $diagnostico->id }}" class="form-label"><strong>Resultado de la IA:</strong></label>
                <textarea id="resultado-ia-{{ $diagnostico->id }}" class="form-control" rows="5" readonly>{{ $diagnostico->resultado_ia }}</textarea>
            </div>
            <div class="mb-2">
                <strong>Fecha y Hora:</strong> {{ $diagnostico->created_at->format('d/m/Y H:i:s') }}
            </div>
            <div>
                <strong>Médico:</strong> 
                {{ $diagnostico->medico->name }} 
                <br>
                <!-- <strong>Apellido:</strong> 
                {{ $diagnostico->medico->a_paterno }}
                <br> -->
                 <!-- {{ $diagnostico->medico->a_materno }} -->
                <!-- <small>{{ $diagnostico->medico->especialidad }}</small> -->
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
