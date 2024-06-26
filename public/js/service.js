document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('solicitar-diagnostico').addEventListener('click', function (e) {
        e.preventDefault();

        var imagen = document.getElementById('imagen');
        var file = imagen.files[0];

        // Comprueba si se ha seleccionado una imagen
        if (!file) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Por favor, selecciona una imagen.",
            });
            return;
        }

        // Comprueba si el archivo es una imagen
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El archivo seleccionado no es una imagen.",
            });
            return;
        }

        // Comprueba el tamaño del archivo (max. 2MB)
        var maxSize = 8 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "La imagen es demasiado grande. El tamaño máximo permitido es de 2MB.",
            });
            return;
        }

        var medico = document.getElementById('medico');

        // Comprueba si se ha seleccionado un médico
        if (!medico.value) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Por favor, selecciona un médico.",
            });
            return;
        }

        var form = document.getElementById('diagnostic-form');
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(response => response.json())
            .then(data => {
                //console.log(data);
                // Aquí puedes manejar la respuesta del servidor
                var datos = data.data;
                console.log(datos);

                // Guarda la URL de la imagen previsualizada
                var imageUrl = document.querySelector('#image-list img').src;

                // Elimina la imagen previsualizada
                var imageList = d3.select('#image-list');
                imageList.html('');

                // $image->scale(457, 347);
                var imageWidth = 757;
                var imageHeight = 647;


                // Crea el SVG dentro del div image-list
                var svg = d3.select("#mySVG");

                /*var svg = imageList.append('svg')
                    .attr('id', 'mySVG')
                    .attr('width', imageWidth)
                    .attr('height', imageHeight);*/

                // Agrega la imagen al SVG
                svg.append('image')
                    .attr('href', imageUrl)
                    .attr('x', 0)
                    .attr('y', 0)
                    .attr('width', imageWidth)
                    .attr('height', imageHeight);

                // Dimensiones originales de la imagen

                //var predictions = datos.predictions;

                // Convertir el JSON a objeto JavaScript
                const datos2 = JSON.parse(datos);

                // Acceder a la lista de predicciones
                const predictions = datos2.predictions;

                predictions.forEach(function (prediction) {
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


            })
            .catch((error) => {
                console.error('Error:', error);
                // Aquí puedes manejar los errores
            });
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
