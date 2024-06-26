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
                    <input hidden type="text" id="cuadro" value="{{$jsonencore}}">
                </div>

                @if (isset($dataApi) && !empty($dataApi->predictions))
                <ul>
                    @foreach ($dataApi->predictions as $prediction)
                        <li>
                          
                            confidence: {{ $prediction->confidence }}, class: {{ $prediction->class }},
                           
                        </li>
                    @endforeach
                </ul>
                @else
                <p>No hay predicciones disponibles</p>
                @endif
                <div style="position: relative; display: inline-block;">
                    <img id="id_imagen" src="{{ asset($ecogrfianew->path) }}" alt="Imagen de Ecografía">
                    <canvas id="id_cuadro" style="border: 1px solid black; position: absolute; top: 0; left: 0;"></canvas>
                </div>

                <!-- Mostrar la imagen -->

            </div>
        </div>
        <div class="col-4" style="background-color: #f7fdf8;"> <!-- Columna de tamaño 4 -->
            <!-- Contenido de la columna -->
   <!-- Contenido de la columna -->
                   
            <p>Obtenga un resultado rapido y eficaz con la ayuda de Inteligencia Artificial y de profesionales</p>
            <h2>Instrucciones:
            </h2>
            <p>enviar la imagen de su ecografia </p>
            <p>se procesara la imagen mediante un mecanismo de Reconocimiento de imagen por IA </p>
            <p>los resultados seran enviados a un profecional segun su plan de suscripcion </p>
            <p>la revision por un profesional sera pronta </p>
            <p>se le daran recomendaciones y un diagnostico segun el profesional designado </p>
            <p>gracias por usar el servicio </p>
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
            try {
                const value = JSON.parse(cuadro.value);

                if (value && value.predictions && value.predictions.length > 0) {
                    const imagen = value.image; // Obtener la información de la imagen
                    const width_img = imagen.width; // Ancho de la imagen
                    const height_img = imagen.height; // Alto de la imagen

                    console.log("Ancho de la imagen: " + width_img + ", Alto de la imagen: " + height_img);

                    const predictions = value.predictions;

                    const canvas = document.getElementById('id_cuadro');
                    canvas.width = width_img; // Redimension del canvas, al tamaño de la imagen
                    canvas.height = height_img;

                    predictions.forEach(prediction => {
                        const { x, y, width, height } = prediction;
                        dibujarRectangulo(x, y, width, height);
                    });
                } else {
                    console.log("No hay datos de predicciones disponibles.");
                }
            } catch (error) {
                console.error("Error al procesar los datos:", error);
            }
        }

        dibujar(); // Llamar a la función para dibujar inicialmente
    });
</script>
