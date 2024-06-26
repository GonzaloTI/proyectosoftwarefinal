@extends('layouts.index')

@section('title', 'IA Online')

@section('content')
    <!-- Page content-->
    <section class="mt-5" style="min-height: 600px;">
        {{-- Crear 3 columnas una de 2, 6 y 4 tambien pintarlas --}}
        <div class="row">
            <div class="col-7" style="background-color:black;"> <!-- Columna de tamaño 6 -->
                <!-- Contenido de la columna -->
                {{-- Aqui crear un card que ocupe todo el ancho y alto de la pagina --}}
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        Resultado
                    </div>

                    @if (isset($dataApi) && !empty($dataApi->predictions))
                    @else
                        <p>No hay predicciones disponibles</p>
                    @endif
                    <div class="card-body">
                        <input type="hidden" id="myImage" value="{{ asset($ecogrfianew->path) }}">
                        <svg id="mySVG" width="757" height="647">
                            {{-- <img src="{{ asset($ecogrfianew->path) }}" alt="Imagen de Ecografía"
                                style="height: 500x; overflow-y: auto;"> --}}
                        </svg>
                    </div>

                    <!-- Mostrar la imagen -->
                </div>
            </div>
            <div class="col-5" style="background-color: #f7fdf8;"> <!-- Columna de tamaño 4 -->
                <!-- Contenido de la columna -->
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        Diagnostico
                    </div>


                </div>

            </div>
        </div>
    </section>
@endsection
{{-- <script>
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
</script> --}}
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var dataApi = @json($dataApi);
        // Imprimir dataApi en la consola
        var imageWidth = dataApi.image.width;
        var imageHeight = dataApi.image.height;

        var imgElement = document.getElementById('myImage');
        var imgSrc = imgElement.value;

        // Crear un elemento SVG
        var svg = d3.select("#mySVG");
        // Establecer el ancho y la altura del SVG
        svg.attr("width", imageWidth)
            .attr("height", imageHeight);

        svg.append('image')
            .attr('href', imgSrc)
            .attr('x', 0)
            .attr('y', 0)
            .attr('width', imageWidth)
            .attr('height', imageHeight);


        const predictions = dataApi.predictions;

        predictions.forEach(function(prediction) {
            var centerXProp = prediction.x / imageWidth;
            var centerYProp = prediction.y / imageHeight;
            var rectWidthProp = prediction.width / imageWidth;
            var rectHeightProp = prediction.height / imageHeight;

            var randomColor = getRandomColor();

            // Agrega el rectángulo encima de la imagen
            svg.append("rect")
                .attr("x", (centerXProp - rectWidthProp / 2) * 100 + "%") // Ajusta la posición x
                .attr("y", (centerYProp - rectHeightProp / 2) * 100 + "%") // Ajusta la posición y
                .attr("width", rectWidthProp * 100 + "%")
                .attr("height", rectHeightProp * 100 + "%")
                .style("stroke", randomColor) // Cambia el color del contorno a verde
                .style("stroke-width", "3") // Hace la línea más gruesa
                .style("fill", "none"); // Elimina el relleno

            // Define el texto y las propiedades del fondo
            var text = prediction.class;
            var padding = 8; // Espacio alrededor del texto
            var fontSize = 12; // Tamaño de la fuente

            // Agrega una etiqueta al rectángulo
            var textElement = svg.append("text")
                .attr("x", (centerXProp - rectWidthProp / 2) * 100 + "%") // Posición x de la etiqueta
                .attr("y", (centerYProp - rectHeightProp / 2) * 100 + "%") // Posición y de la etiqueta
                .text(text) // Texto de la etiqueta
                .style("font-size", fontSize + "px") // Tamaño de la fuente
                .style("fill", "white"); // Color del texto

            // Obtiene las dimensiones del texto
            var bbox = textElement.node().getBBox();

            // Agrega un rectángulo detrás del texto
            svg.insert("rect", "text")
                .attr("x", bbox.x - padding)
                .attr("y", bbox.y - padding)
                .attr("width", bbox.width + 2 * padding)
                .attr("height", bbox.height + 2 * padding)
                .style("fill", randomColor); // Color del fondo

            // Mueve el texto al frente
            textElement.raise();
        });
    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
