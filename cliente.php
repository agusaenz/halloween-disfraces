<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo</title>

    <!-- librerias -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script defer src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>

    <style>
        body {
            padding: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }
    </style>

    <script>
        function cargarCliente() {
            /* 
            FALTA:
            - agregar validaciones
            - modificar datos segun variables ingresadas
            */

            // guardo en variables los datos ingresados, utilizando el selector
            // por id de jquery.
            let apellidos = $('#apellidos').val();
            let nombres = $('#nombres').val();
            let numeroDocumento = $('#numeroDocumento').val();
            let telefono = $('#telefono').val();
            let domicilio = $('#domicilio').val();
            let correo = $('#correo').val();

            // armo un string de "consulta url" datos, donde guardo todas las variables
            let datos = "apellidos=" + apellidos + "&nombres=" + nombres + "&numeroDocumento=" + numeroDocumento  + "&telefono=" + telefono + 
            "&domicilio=" + domicilio + "&correo=" + correo;

            // funcion ajax que usamos siempre que enviemos informacion a un archivo back
            $.ajax({
                url: 'ajax/cliente/guardarCliente.php',
                type: 'POST',
                data: datos,
                dataType: 'json',
                success: function (data) {
                    if (data.estado == 1) {
                        alert("Cliente cargado correctamente.");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus, errorThrown);
                }
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center mb-4">Agregar cliente</h2>
                <div class="form-group">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input id="apellidos" class="form-control" type="text" placeholder="Apellidos"
                        aria-label="default input example">
                </div>
                <div class="form-group">
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input id="nombres" class="form-control" type="text" placeholder="Nombres"
                        aria-label="default input example">
                </div>
                <div class="form-group">
                    <label for="numeroDocumento" class="form-label">DNI:</label>
                    <input id="numeroDocumento" class="form-control" type="text" placeholder="Número de documento"
                        aria-label="default input example">
                </div>
                <div class="form-group">
                    <label for="telefono" class="form-label">Telefono:</label>
                    <input id="telefono" class="form-control" type="text" placeholder="Telefono"
                        aria-label="default input example">
                </div>
                <div class="form-group">
                    <label for="domicilio" class="form-label">Domicilio:</label>
                    <input id="domicilio" class="form-control" type="text" placeholder="Domicilio"
                        aria-label="default input example">
                </div>
                <div class="form-group">
                    <label for="correo" class="form-label">Correo:</label>
                    <input id="correo" class="form-control" type="email" placeholder="Correo electrónico"
                        aria-label="default input example">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" onclick="cargarCliente()">Cargar cliente</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>