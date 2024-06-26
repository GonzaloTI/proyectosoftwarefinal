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
                <div class="card-header">
                    <form method="POST" action="{{ route('diagnosticos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" id="image" name="image" style="display: none;">
                        <label for="image" class="btn btn-primary">Agregar imagen</label>



                        <button type="submit" class="btn btn-primary">Solicitar Diagnóstico</button>
                    </form>
                </div>
                <div class="card-body" id="image-list" style="height: 100px; overflow-y: auto;">
                    <!-- Las imágenes se agregarán aquí -->
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
                <div>
                    <input type="text" id="cuadro" value="{{$jsonencore}}">
                </div>

                @if (isset($dataApi) && !empty($dataApi->predictions))

                <ul>
                    @foreach ($dataApi->predictions as $prediction)
                    <li>
                        x: {{ $prediction->x }}, y: {{ $prediction->y }},
                        width: {{ $prediction->width }}, height: {{ $prediction->height }},
                        confidence: {{ $prediction->confidence }}, class: {{ $prediction->class }},
                        class_id: {{ $prediction->class_id }}, detection_id: {{ $prediction->detection_id }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p>No hay predicciones disponibles</p>
                @endif
                <div style="position: relative; display: inline-block;">
                    <img src="{{ asset($ecogrfianew->path) }}" alt="Imagen de Ecografía" style="height: 500px; overflow-y: auto;">
                    <canvas id="id_cuadro" width="500" height="500" style="border: 1px solid black; position: absolute; top: 0; left: 0;"></canvas>
                </div>

                <!-- Mostrar la imagen -->

            </div>
        </div>
        <div class="col-4" style="background-color: #f7fdf8;"> <!-- Columna de tamaño 4 -->
            <!-- Contenido de la columna -->

        </div>
    </div>

</section>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function dibujarRectangulo(x, y, width, height) {
            const canvas = document.getElementById('id_cuadro');
            const ctx = canvas.getContext('2d');
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.rect(x, y, width, height);
            ctx.stroke();
            ctx.closePath();
        }

        function dibujar() {
            const cuadro = document.getElementById("cuadro");
            const value = JSON.parse(cuadro.value);
            if (value && value.predictions && value.predictions.length > 0) {
                const prediction = value.predictions[0]; // Tomar la primera predicción
                const {
                    x,
                    y,
                    width,
                    height
                } = prediction;
                dibujarRectangulo(x, y, width, height);
            } else {
                console.log("No hay datos de predicciones disponibles.");
            }
        }

        dibujar(); // Llamar a la función para dibujar inicialmente
    });
</script>
    <!-- Page content-->
    <section class="mt-5" style="height: 100%">
        {{-- Crear 3 columnas una de 2, 6 y 4 tambien pintarlas --}}
        <div class="row">
            <div class="col-2" style="background-color:black;"> <!-- Columna de tamaño 2 -->
                <!-- Contenido de la columna -->
                {{-- Aqui crear un card con un boton arriba que diga subir imagen, el card debe ocupar todo el alto de la pagina --}}
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        <form method="POST" action="{{ route('diagnosticos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control" id="image" name="image" style="display: none;">
                            <label for="image" class="btn btn-primary">Agregar imagen</label>
                        
                         
                        
                            <button type="submit" class="btn btn-primary">Solicitar Diagnóstico</button>
                        </form>
                    </div>
                    <div class="card-body" id="image-list" style="height: 100px; overflow-y: auto;">
                        <!-- Las imágenes se agregarán aquí -->
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

                    @if (isset($dataApi) && !empty($dataApi->predictions))
                    <ul>
                        @foreach ($dataApi->predictions as $prediction)
                            <li>
                                x: {{ $prediction->x }}, y: {{ $prediction->y }}, 
                                width: {{ $prediction->width }}, height: {{ $prediction->height }},
                                confidence: {{ $prediction->confidence }}, class: {{ $prediction->class }},
                                class_id: {{ $prediction->class_id }}, detection_id: {{ $prediction->detection_id }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay predicciones disponibles</p>
                @endif
                    <div class="card-body">
                       
                        
                        <img src="{{ asset($ecogrfianew->path) }}" alt="Imagen de Ecografía"  style="height: 500px; overflow-y: auto;">
                    </div>

                    <!-- Mostrar la imagen -->
                 
                



                </div>
            </div>
            <div class="col-4" style="background-color: #f7fdf8;"> <!-- Columna de tamaño 4 -->
                <!-- Contenido de la columna -->
              
            </div>
        </div>
        <div class="card-body">
            <div class="image-container" style="position: relative;">
                <img src="{{ asset($ecogrfianew->path) }}" alt="Imagen de Ecografía" id="ecografia-image" style="max-width: 100%; height: auto;">
                <canvas id="canvas" style="position: absolute; top: 0; left: 0;"></canvas>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const image = document.getElementById('ecografia-image');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        image.onload = function() {
            // Ajustar el canvas al tamaño de la imagen
            canvas.width = image.naturalWidth;
            canvas.height = image.naturalHeight;

            // Dibujar una línea en el medio de la imagen
            ctx.beginPath();
            ctx.moveTo(0, canvas.height / 2);
            ctx.lineTo(canvas.width, canvas.height / 2);
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 2;
            ctx.stroke();
        };
    });
</script>
@endpush
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('image').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Image preview';
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                document.getElementById('image-list').appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
