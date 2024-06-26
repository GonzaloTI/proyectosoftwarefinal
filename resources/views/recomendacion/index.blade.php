@extends('layouts.index')



@section('content')
<h1 class="text-center" style="font-weight: bold;" class="mb-4">Recomendaciones del médico</h1>
<div class="container">
    <h1 class="text-center">Recomendaciones del médico</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre del Médico</th>
                    <th>Recomendación</th>
                    <th>Fecha y hora</th>
                    <th>Imágenes</th> <!-- Nuevo encabezado para las imágenes -->
                </tr>
            </thead>
            <tbody>
                @forelse ($recomendaciones as $recomendacion)
                <tr>
                    <td>{{ $recomendacion->nombre_medico }}</td>
                    <td>{{ $recomendacion->recomendacion }}</td>
                    <td>{{ $recomendacion->created_at }}</td>
                    <td>
                        <div class="d-flex flex-wrap">
                            @foreach ($recomendacion->diagnostico->ecografias as $imagen)
                                <img src="{{ asset($imagen->path) }}" alt="Ecografía" class="img-thumbnail m-2" style="max-width: 200px;">
                            @endforeach
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No hay recomendaciones registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
