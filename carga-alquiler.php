<?php
require_once ('sidebar.php');
include 'ajax/auth.php';

// recupero id si viene de editar
$idAlquiler = 0;
if (isset($_GET["idAlquiler"]) && is_numeric($_GET["idAlquiler"])) {
  $idAlquiler = filter_input(INPUT_GET, 'idAlquiler', FILTER_SANITIZE_NUMBER_INT);
}
// __numero_documento de lista-clientes
$__numero_documento = 0;
if (isset($_GET["__numero_documento"]) && is_numeric($_GET["__numero_documento"])) {
  $__numero_documento = filter_input(INPUT_GET, '__numero_documento', FILTER_SANITIZE_NUMBER_INT);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cargar alquiler</title>
  <link rel="icon" href="assets/img/icon.png">

  <!-- Librerías -->
  <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css">
  <script defer src="assets/includes/js/bootstrap.bundle.min.js"></script>
  <script src="assets/includes/js/jquery-3.7.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <script src="assets/js/sidebar.js"> </script>

  <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #b39b9b;
      font-family: 'Roboto', sans-serif;
      font-size: 0.9rem;
      margin: 0;
      overflow: hidden;
      /* Evita el scrolling de la página */
    }

    .alquiler {
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      /* Permite el scrolling si es necesario */
    }

    .customform-alquiler {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      width: 60vw;
      /* subo ancho */
      height: 80vh;
      /* subo altura */
      overflow: auto;
    }

    .form-label {
      font-weight: 500;
      margin-bottom: 5px;
    }

    .form-group {
      margin-bottom: 20px;
      width: 100%;
    }

    .formcontrol-alquiler {
      width: 100%;
      box-sizing: border-box;
      border-radius: 10px;
      background-color: #ffffff;
      padding: 10px;
      border: 1px solid #ced4da;
      transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .form-control[disabled] {
      background-color: #f2f2f2;
      cursor: not-allowed;
    }

    .form-control.disabled-input {
      background-color: #f2f2f2;
    }

    .form-control.custom-color {
      background-color: #ffffff;
      /* Color personalizado cuando está activado */
    }

    .btn-custom-alquiler {
      background-color: #267ecf;
      color: white;
      padding: 7.3px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #a2caf0;
    }

    .horizontal-group {
      display: flex;
      flex-wrap: wrap;
      /* Permite que los elementos se envuelvan si no caben en una línea */
      gap: 15px;
    }

    .date-group {
      display: flex;
      gap: 2px;
      align-items: center;
    }

    .align-center {
      display: flex;
      align-items: center;
    }

    .custom-br-divider {
      display: block;
      height: 10px;
      width: 100%;
      background-color: transparent;
    }

    .custom-br-text {
      display: block;
      height: 3px;
      width: 100%;
      background-color: transparent;
    }

    .article-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn-print {
      background-color: #28a745;
      /* Color verde para el botón de imprimir */
      color: white;
      padding: 7.3px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: background-color 0.3s ease;
    }

    .btn-print:hover {
      background-color: #218838;
      /* Color verde más oscuro para el hover */
    }

    .col-md-6-alquiler {
      flex: 0 0 45%;
      /* Ajustar el tamaño de los campos al 48% del contenedor para dejar espacio entre ellos */
    }

    .col-md-4-alquiler {
      flex: 0 0 30%;
      /* Ajustar el tamaño de los campos al 48% del contenedor para dejar espacio entre ellos */
    }

    .col-md-2-alquiler {
      flex: 0 0 40%;
    }

    .row-centered {
      display: flex;
      justify-content: center;
    }


    /* Estilo para el título del formulario */
    h2.form-title {
      text-align: left;
      margin-bottom: 20px;
      font-size: 1.0rem;
      font-weight: bold;
      color: #333;
      /* Color de texto personalizado */
    }

    .btn-standard-font {
      font-size: 1.0rem;
    }

    @media (max-width: 768px) {
      .col-md-6-alquiler {
        flex: 0 0 100%;
        /* Para pantallas pequeñas, los campos ocuparán el 100% del ancho */
      }
    }

    .sidebar-container {
      width: 250px;
      flex-shrink: 0;
    }

    .content-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      overflow-y: auto;
      margin-top: 70px;
    }

    @media (max-height: 700px) {
      .content-container {
        margin-top: 50px;
      }
    }


    .btn-volver {
      background-color: #267ecf;
      color: white;
      padding: 7.3px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: background-color 0.3s ease;
      position: fixed;
      bottom: 85vh;
      left: 18vw;
      z-index: 1000;
    }

    .btn-volver:hover {
      background-color: #267ecf;
    
    }
  </style>
</head>

<body>

  <div class="sidebar-container">
    <?php
    echo $sidebar;
    ?>
  </div>

  <div>
    <a id="volverListaAlq" class="btn btn-volver" href="lista-alquileres.php"><i class="bi bi-arrow-left"></i> Volver</a>
    <a id="volverListaCli" class="btn btn-volver" href="lista-clientes.php"><i class="bi bi-arrow-left"></i> Volver</a>
  </div>


  <div class="content-container alquiler">

    <form class="custom-form customform-alquiler" id="resizable-form">
      <h2 class="form-title" id="titulo-alquiler">Alquiler</h2>
      <hr class="my-2">
      <section class="custom-br-divider"> </section> <!-- Implementación de la clase custom-br -->
      <div class="form-group col-md-6 col-md-6-alquiler">
        <div class="col-md-6 col-md-6-alquiler" id="form-group">
          <label class="form-label" for="documento"><i class="bi bi-file-earmark-text"></i> Documento</label>
          <section class="custom-br-text"> </section>
          <div class="align-center">
            <input type="text" id="documento" class="form-control formcontrol-alquiler" />
            <aside>&nbsp; &nbsp; &nbsp;</aside>
            <button type="button" id="buscarBtn" class="btn btn-custom btn-custom-alquiler ms-2"
              onclick="buscarDNI()"><i class="bi bi-search"></i> Buscar</button>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="horizontal-group">
          <div class="form-group col-md-6 col-md-6-alquiler">
            <label class="form-label" for="nombre"><i class="bi bi-person-circle"></i> Nombre y apellido</label>
            <section class="custom-br-text"></section>
            <input type="text" id="nombre" class="form-control disabled-input" disabled />
          </div>
          <div class="form-group col-md-6 col-md-6-alquiler">
            <label class="form-label" for="correo"><i class="bi bi-envelope"></i> Correo</label>
            <section class="custom-br-text"></section>
            <input type="email" id="correo" class="form-control disabled-input" disabled />
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="horizontal-group">
          <div class="form-group col-md-6 col-md-6-alquiler">
            <label class="form-label" for="celular"><i class="bi bi-telephone"></i> Celular</label>
            <section class="custom-br-text"></section>
            <input type="text" id="celular" class="form-control disabled-input" disabled />
          </div>
          <div class="form-group col-md-6 col-md-6-alquiler">
            <label class="form-label" for="direccion"><i class="bi bi-geo-alt"></i> Dirección</label>
            <section class="custom-br-text"></section>
            <input type="text" id="direccion" class="form-control disabled-input" disabled />
          </div>
        </div>
      </div>

      <div id="divCheckboxAsociar" class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault"> Alquiler sin asociar</label>
      </div>

      <hr class="my-4">
      <section class="custom-br-divider"> </section> <!-- Implementación de la clase custom-br -->

      <div class="form-group mb-4">
        <label class="form-label"><i class="bi bi-list"></i> Disfraces </label>
        <section class="custom-br-text"> </section>
        <div id="articles-section">
          <div class="form-group article-group">
            <input type="text" id="disfraz" class="form-control formcontrol-alquiler" />
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-2 col-md-2-alquiler form-group">
          <label class="form-label"><i class="bi bi-calendar"></i> Fecha de alquiler</label>
          <section class="custom-br-text"></section>

          <input type="date" id="fechaAlq" class="form-control formcontrol-alquiler" placeholder="Fecha fin"
            lang="es" />

        </div>
        <div class="col-md-2 col-md-2-alquiler form-group">
          <label class="form-label"><i class="bi bi-calendar"></i> Fecha de devolución</label>
          <section class="custom-br-text"></section>

          <input type="date" id="fechaDev" class="form-control formcontrol-alquiler" placeholder="Fecha fin"
            lang="es" />

        </div>
        <div class="col-md-2 col-md-2-alquiler form-group">

          <label class="form-label"><i class="bi bi-building"></i> Escuela</label>
          <section class="custom-br-text"></section>
          <input type="text" id="escuela" class="form-control formcontrol-alquiler" />
        </div>
        <div class="col-md-2 col-md-2-alquiler form-group">

          <label class="form-label"><i class="bi bi-handbag"></i> Bolsas</label>
          <section class="custom-br-text"></section>
          <input type="number" id="bolsas" class="form-control formcontrol-alquiler" />
        </div>

      </div>

      <div class="row mb-4 ">

        <div class="col-md-4 col-md-4-alquiler form-group">
          <label class="form-label"><i class="bi bi-cash"></i> Total</label>
          <section class="custom-br-text"></section>
          <input type="number" id="total" class="form-control formcontrol-alquiler" />
        </div>

        <div class="col-md-4 col-md-4-alquiler form-group">
          <label class="form-label"><i class="bi bi-cash"></i> Depósito</label>
          <section class="custom-br-text"></section>
          <input type="number" id="deposito" class="form-control formcontrol-alquiler" />
        </div>

        <div class="col-md-4 col-md-4-alquiler form-group">
          <label class="form-label"><i class="bi bi-credit-card"></i> Forma de pago</label>
          <section class="custom-br-text"></section>
          <select id="formaPago" class="form-control formcontrol-alquiler">
            <option value="efectivo">Efectivo</option>
            <option value="debito">Débito</option>
            <option value="credito">Crédito</option>
            <option value="transferencia">Transferencia / QR</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="detalle"><i class="bi bi-pencil-square"></i> Detalle</label>

        <textarea class="form-control formcontrol-alquiler" id="detalle" rows="4"></textarea>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-between">
        <div>
          <button id="boton-guardar" type="button" class="btn btn-custom btn-custom-alquiler btn-standard-font"
            onclick="cargarAlquiler()"><i class="bi bi-save"></i>
            Guardar</button>
          <button type="button" class="btn btn-danger btn-standard-font" onclick="window.location.href='main.php';return false;"><i class="bi bi-x-circle"></i>
            Cancelar</button>
        </div>
        <button type="button" class="btn btn-print btn-standard-font" onclick="imprimirAlquiler()"><i class="bi bi-printer"></i> Imprimir</button>
      </div>
    </form>
  </div>

  <script>
    // guardo id en global para editar
    var idAlquiler = <?php echo $idAlquiler; ?>;
    var __numero_documento = <?php echo $__numero_documento; ?>;

    function buscarDNI() {
      let dni = $('#documento').val();
      if (!dni && dni != "" && dni != undefined) {
        alert("Ingrese un DNI para buscar.");
        return;
      }

      let datos = "dni=" + dni;

      $.ajax({
        type: "POST",
        url: "ajax/alquiler/buscarCliente.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          if (data.estado == 1) {
            let nombres = data.cliente.nombres;
            let apellido = data.cliente.apellidos;
            let telefono = data.cliente.telefono;
            let domicilio = data.cliente.domicilio;
            let correo = (data.cliente.correo != "") ? data.cliente.correo : '-';

            $('#nombre').val(apellido + ", " + nombres);
            $('#correo').val(correo);
            $('#celular').val(telefono);
            $('#direccion').val(domicilio);
          } else if (data.estado == 2) {
            alert("No se ha encontrado ningún cliente con DNI " + dni + ".");
          }
        },
        error: function () {
          alert("Ha ocurrido un error durante la operación.");
        },
      });
    }

    function cargarAlquiler() {
      let variablesFaltantes = [];
      let vars = [{
        id: 'disfraz',
        name: 'Disfraz'
      },
      {
        id: 'fechaAlq',
        name: 'Fecha Alquiler'
      },
      {
        id: 'fechaDev',
        name: 'Fecha Devolución'
      },
      {
        id: 'total',
        name: 'Total'
      },
      {
        id: 'deposito',
        name: 'Depósito'
      },
      {
        id: 'formaPago',
        name: 'Forma de Pago'
      },
      {
        id: 'detalle',
        name: 'Detalle'
      }
      ];

      vars.forEach(function (vars) {
        if (!$(`#${vars.id}`).val()) {
          variablesFaltantes.push(vars.name);
        }
      });

      if (variablesFaltantes.length > 0) {
        let message = 'Los siguientes campos no se han rellenado:\n - ' + variablesFaltantes.join('\n - ') + '\n\n¿Desea continuar?';
        if (!confirm(message)) {
          return;
        }
      }

      let datosArray = [];

      vars.forEach(function (vars) {
        let value = $(`#${vars.id}`).val();
        if (value) {
          datosArray.push(`${vars.id}=${value}`);
        }
      });

      let datos = datosArray.join('&');

      let dni = $('#documento').val();
      if (!$('#flexSwitchCheckDefault').is(":checked") && dni && dni != "") {
        datos += "&dni=" + dni;
      }

      let __id = -1;
      // si pasé id (editar), la igualo, sino, la mando en 0
      if (idAlquiler != undefined && idAlquiler != 0) __id = idAlquiler;
      datos += "&idAlquiler=" + __id;

      let escuela = $('#escuela').val();
      let bolsas = $('#bolsas').val();
      if (escuela != undefined && escuela != '') datos += "&escuela=" + escuela;
      if (bolsas != undefined && bolsas != '' && bolsas != 0) datos += "&bolsas=" + bolsas;

      $.ajax({
        type: "POST",
        url: "ajax/alquiler/registrarAlquiler.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          if (data.estado == 1) {
            alert("Alquiler cargado exitosamente.");
            $('input').val('');
            $('textarea').val('');
            $('#formaPago').val('efectivo');
            idAlquiler = -1;
          } else if (data.estado == 2) {
            alert("Ha ocurrido un error durante la operación.");
          }
        },
        error: function () {
          alert("Ha ocurrido un error durante la operación.");
        },
      });
    }

    function buscarAlquiler() {
      let datos = "idAlquiler=" + idAlquiler;

      if (idAlquiler != -1 && idAlquiler != 0) {
        $.ajax({
          type: 'POST',
          url: 'ajax/alquiler/recuperarAlquiler.php',
          data: datos,
          dataType: 'json',
          success: function (data) {
            if (data.estado == 1) {
              let correo = data.alquiler.correo;
              let apellidos = data.alquiler.apellidos;
              let deposito = data.alquiler.deposito;
              let detalle = data.alquiler.detalle;
              let disfraces = data.alquiler.disfraces;
              let domicilio = data.alquiler.domicilio;
              let fechaAlquiler = data.alquiler.fechaAlquiler;
              let fechaDevolucion = data.alquiler.fechaDevolucion;
              let formaDePago = data.alquiler.formaDePago;
              let nombres = data.alquiler.nombres;
              let numero_documento = data.alquiler.numero_documento;
              let telefono = data.alquiler.telefono;
              let total = data.alquiler.total;
              let escuela = data.alquiler.escuela;
              let bolsas = data.alquiler.bolsas;

              $('#documento').val(numero_documento);
              $('#nombre').val(apellidos + ", " + nombres);
              $('#correo').val(correo);
              $('#celular').val(telefono);
              $('#direccion').val(domicilio);

              $('#disfraz').val(disfraces);
              $('#total').val(total);
              $('#deposito').val(deposito);
              $('#detalle').val(detalle);
              $('#escuela').val(escuela);
              $('#bolsas').val(bolsas);

              $('#fechaAlq').val(fechaFormateada(fechaAlquiler));
              $('#fechaDev').val(fechaFormateada(fechaDevolucion));

              switch (formaDePago) {
                case 1:
                  $('#formaPago').val('efectivo');
                  break;
                case 2:
                  $('#formaPago').val('credito');
                  break;
                case 3:
                  $('#formaPago').val('debito');
                  break;
                case 4:
                  $('#formaPago').val('transferencia');
                  break;
                default:
                  $('#formaPago').val('efectivo');
                  break;
              }

            }
          },
          error: function (txt) {
            alert("Ha ocurrido un error. Por favor, intente nuevamente en unos minutos.");
          }
        });
      }
    }

    function fechaFormateada(dateStr) {
      let parts = dateStr.split('/');
      return parts[2] + '-' + parts[1] + '-' + parts[0];
    }

    function imprimirAlquiler() {
      let documento = $("#documento").val();
      let nombre = $("#nombre").val();
      let correo = $("#correo").val();
      let telefono = $("#celular").val();
      let direccion = $("#direccion").val();

      let disfraz = $('#disfraz').val();
      let fechaAlq = $('#fechaAlq').val();
      let fechaDev = $('#fechaDev').val();
      let escuela = $('#escuela').val();
      let bolsas = $('#bolsas').val();
      let total = $('#total').val();
      let deposito = $('#deposito').val();
      let formaPago = $('#formaPago').val();
      let detalle = $('#detalle').val();

      let datos = "documento=" + documento + "&nombre=" + nombre + "&correo=" + correo + "&telefono=" + telefono +
        "&direccion=" + direccion + "&disfraz=" + disfraz + "&fechaAlq=" + fechaAlq +
        "&fechaDev=" + fechaDev + "&escuela=" + escuela + "&bolsas=" + bolsas +
        "&total=" + total + "&deposito=" + deposito + "&formaPago=" + formaPago +
        "&detalle=" + detalle;

      $.ajax({
        type: 'POST',
        url: 'ajax/generar_pdf.php',
        data: datos,
        xhrFields: {
          responseType: 'blob'
        },
        success: function (response) {
          var blob = new Blob([response], { type: 'application/pdf' });
          var url = URL.createObjectURL(blob);
          window.open(url);
        }
      });
    }

    $(document).ready(function () {
      const documentoInput = $("#documento");
      const nombreInput = $("#nombre");
      const correoInput = $("#correo");
      const celularInput = $("#celular");
      const direccionInput = $("#direccion");
      const buscarBtn = $("#buscarBtn"); // Seleccionar el botón de buscar
      const volverListaAlq = $('#volverListaAlq');
      const volverListaCli = $('#volverListaCli');
      volverListaAlq.hide();
      volverListaCli.hide();

      // limpio todos los inputs
      $('input').val('');
      $('textarea').val('');
      $('#flexSwitchCheckDefault').prop("checked", false);
      $('input[type=number]').on('wheel', function (e) {
        e.preventDefault();
      });

      if (idAlquiler != undefined && idAlquiler != 0 && idAlquiler != -1) {
        documentoInput.prop("disabled", true);
        buscarBtn.prop("disabled", true);
        volverListaAlq.show();
        $('#divCheckboxAsociar').hide();
        buscarAlquiler();
        $('#titulo-alquiler').html('Editar Alquiler');
        $('#boton-guardar').text('Guardar cambios');
      }

      if (__numero_documento != undefined && __numero_documento != 0 && __numero_documento != -1) {
        $('#documento').val(__numero_documento);
        buscarDNI();
        documentoInput.prop("disabled", true);
        buscarBtn.prop("disabled", true);
        volverListaCli.show();
        $('#divCheckboxAsociar').hide();
      }

      $("#flexSwitchCheckDefault").on("change", function () {
        documentoInput.val('');
        nombreInput.val('');
        correoInput.val('');
        celularInput.val('');
        direccionInput.val('');
        if ($(this).is(":checked")) {
          documentoInput.prop("disabled", true);
          nombreInput.prop("disabled", false);
          correoInput.prop("disabled", false);
          celularInput.prop("disabled", false);
          direccionInput.prop("disabled", false);

          buscarBtn.prop("disabled", true); // Deshabilitar el botón de buscar
          documentoInput.css("background-color", "#f2f2f2");
          nombreInput.removeClass("disabled-input").addClass("custom-color");
          correoInput.removeClass("disabled-input").addClass("custom-color");
          celularInput.removeClass("disabled-input").addClass("custom-color");
          direccionInput.removeClass("disabled-input").addClass("custom-color");

        } else {
          documentoInput.prop("disabled", false);
          nombreInput.prop("disabled", true);
          correoInput.prop("disabled", true);
          celularInput.prop("disabled", true);
          direccionInput.prop("disabled", true);

          buscarBtn.prop("disabled", false); // Habilitar el botón de buscar
          documentoInput.css("background-color", "#ffffff");
          nombreInput.addClass("disabled-input").removeClass("custom-color");
          correoInput.addClass("disabled-input").removeClass("custom-color");
          celularInput.addClass("disabled-input").removeClass("custom-color");
          direccionInput.addClass("disabled-input").removeClass("custom-color");

        }
      });
    });
    adjustSidebarWidth(200)
  </script>

</body>

</html>