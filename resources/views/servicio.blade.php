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
                        <input type="file" class="form-control" id="image" name="image" style="display: none;">
                        <label for="image" class="btn btn-primary">Agregar imagen</label>
                    </div>
                    <div class="card-body" id="image-list" style="height: 200px; overflow-y: auto;">
                        <!-- Las imágenes se agregarán aquí -->
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Procesar</button>
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
                    <div class="card-body">
                        <img src="https://via.placeholder.com/800x600" class="img-fluid" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-4" style="background-color: #d4edda;"> <!-- Columna de tamaño 4 -->
                <!-- Contenido de la columna -->
            </div>
        </div>
    </section>
@endsection
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
