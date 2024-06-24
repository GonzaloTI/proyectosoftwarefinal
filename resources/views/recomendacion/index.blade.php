@extends('layouts.app')

@section('title', 'Lista de Recomendaciones')

@section('content')
<div class="container">
    <h1 class="text-center">Lista de Recomendaciones</h1>

    <!-- <div class="text-right mb-3">
        <a href="{{ route('recomendacion.create') }}" class="btn btn-primary">Crear Nueva Recomendación</a>
    </div> -->

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!-- <th>ID</th>
                    <th>Diagnóstico ID</th> -->
                    <th>Nombre del Médico</th> <!-- Nuevo encabezado para mostrar el nombre del médico -->
                    <th>Recomendación</th>
           
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse ($recomendaciones as $recomendacion)
                <tr>
                    <!-- <td>{{ $recomendacion->id }}</td>
                    <td>{{ $recomendacion->diagnostico_id }}</td> -->
                    <td>{{ $recomendacion->nombre_medico }}</td> <!-- Mostrar el nombre del médico -->
                    <td>{{ $recomendacion->recomendacion }}</td>
                    
                    <!-- <td>
                        <div class="btn-group">
                            <a href="{{ route('recomendacion.show', $recomendacion->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('recomendacion.edit', $recomendacion->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('recomendacion.destroy', $recomendacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta recomendación?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </td> -->
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay recomendaciones registradas.</td>
                </tr>
                @endforelse
            </tbody>
            
        </table>
        <a href="{{ route('cliente.index') }}" class="btn btn-primary">Volver</a>
    </div>
</div>
@endsection
