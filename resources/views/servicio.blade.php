@extends('layouts.index')

@section('title', 'IA Online')

@section('content')
    <!-- Page content-->
    <section class="mt-5" style="height: 100%">
        {{-- Crear 3 columnas una de 2, 6 y 4 tambien pintarlas --}}
        <div class="row">
            <div class="col-2" style="background-color:black;"> <!-- Columna de tamaño 2 -->
                <!-- Contenido de la columna -->
                {{-- Aqui crear un card con un boton arriba que diga subir imagen, el card debe ocupar todo el alto de la pagina --}}
                <div class="card" style="height: 100%;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('diagnosticos.api.enviar') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control" id="imagen" name="imagen" style="display: none;">
                            <label for="imagen" class="btn btn-dark">Agregar imagen</label>
                            <div class="form-group mt-3">
                                <label for="medico">Seleccionar Medico:</label>
                                <select class="form-control" id="medico" name="medico">
                                    @foreach ($medicos as $medico)
                                        <option value="{{ $medico->id }}">
                                            {{ $medico->nombre }} {{ $medico->a_paterno }} {{ $medico->a_materno }} -
                                            {{ $medico->especialidad }} - {{ $medico->telefono }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Solicitar Diagnóstico</button>
                        </form>
                    </div>

                </div>

            </div>
            <div class="col-6" style="background-color:black;"> <!-- Columna de tamaño 6 -->
                <!-- Contenido de la columna -->
                {{-- Aqui crear un card que ocupe todo el ancho y alto de la pagina --}}
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        Resultado
                    </div>
                    <!-- <div class="card-body">
                                                            <img src="https://via.placeholder.com/800x600" class="img-fluid" alt="...">
                                                        </div>-->
                    
                    <div class="img-fluid" id="image-list" style="height: 647; width:757; overflow-y: auto;">
                        <!-- Las imágenes se agregarán aquí -->
                    </div>
                    <svg id="mySVG" width="757" height="647">

                    </svg>
                </div>
            </div>
            <div class="col-4" style="background-color: #f7fdf8;"> <!-- Columna de tamaño 4 -->
                <div class="card">
                    <div class="card-body">
                        <!-- Contenido de la columna -->
                        <p>Obtenga un resultado rapido y eficaz con la ayuda de Inteligencia Artificial y de profesionales
                        </p>
                        <h2>Instrucciones:
                        </h2>
                        <p>Por favor, envíe la imagen de su ecografía.</p>
                        <p>La imagen se procesará mediante un mecanismo de reconocimiento de imagen por IA.</p>
                        <p>Los resultados serán enviados a un profesional según su plan de suscripción.</p>
                        <p>La revisión por un profesional será rápida.</p>
                        <p>Se le darán recomendaciones y un diagnóstico según el profesional designado.</p>
                        <p>Gracias por usar el servicio.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('js/service.js') }}"></script>
    @endpush
@endsection
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('imagen').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Image preview';
                document.getElementById('image-list').appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
