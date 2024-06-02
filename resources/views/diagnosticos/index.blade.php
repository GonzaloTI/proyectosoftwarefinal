

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Solicitud de Diagnósticos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CI</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>
                    <th scope="col">Acciones</th> <!-- Nueva columna para el botón -->
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosticos as $diagnostico)
                <tr>
                    <td>{{ $diagnostico->ci }}</td>
                    <td>{{ $diagnostico->nombre }}</td>
                    <td>{{ $diagnostico->a_paterno }}</td>
                    <td>{{ $diagnostico->a_materno }}</td>
                    <td>
                        <!-- Botón para ver detalles -->
                        <a class="btn btn-primary">Enviar Diagnostico</a>
                          <!-- Botón para ver detalles -->
                 
                    </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
