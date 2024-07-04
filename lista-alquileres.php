<?php
require_once ('sidebar.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lista de Alquileres</title>
  <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/includes/DataTables/datatables.min.css">
  <script src="assets/includes/js/jquery-3.7.1.min.js"></script>
  <script src="assets/includes/js/bootstrap.bundle.min.js"></script>
  <script src="assets/includes/DataTables/datatables.min.js"></script>
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <script src="assets/js/sidebar.js"> </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      height: 100vh;
      background-color: #b39b9b;
      font-family: "Roboto", sans-serif;
      font-size: 0.9rem;
      margin: 0;
    }

    .sidebar-container {
      width: 250px;
      flex-shrink: 0;
    }

    .content-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 20px;
      overflow-y: auto;
      margin-top: 70px;
    }

    .custom-form {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      overflow: auto;
      min-width: 300px;
      min-height: 400px;
      width: 100%;
      max-width: 1300px;
      max-height: 90vh;
    }

    .modal-body {
      max-height: 70vh;
      overflow-y: auto;
    }

    .btn-lg-custom {
      padding: 10px 20px;
      font-size: 1.25rem;
    }

    @media (max-width: 768px) {
      .btn-lg-custom {
        width: 100%;
        margin-top: 10px;
      }
    }

    @media (max-height: 700px) {
      .content-container {
        margin-top: 50px;
      }
    }

    .filter-label {
      font-size: 1.15rem;
      margin-right: 10px;
      font-weight: bold;
    }

    .align-items-center {
      display: flex;
      align-items: center;
    }

    .me-2 {
      margin-right: 0.5rem;
    }

    .fecha-inputs {
      display: flex;
      margin-top: 10px;
      margin-bottom: 10px;
      font-size: 1.1rem;
      width: 500px !important
    }

    .align-label {
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="sidebar-container">
    <?php
    echo $sidebar;
    ?>
  </div>
  <div class="content-container">
    <form class="custom-form" id="resizable-form" onsubmit="return false;">
      <h1 class="text-center">Lista de Alquileres</h1>
      <div class="row align-items-center justify-content-center">
        <div class="col-md-3 fecha-inputs">
          <label class="me-2 align-label">Desde:</label>
          <input type="date" id="fechaInicio" class="form-control me-2 fecha-input" />
          <label class="me-2 align-label">Hasta:</label>
          <input type="date" id="fechaFin" class="form-control me-2 fecha-input" />
        </div>

        <div class="col-md-3">
          <input type="text" id="dniBusqueda" class="form-control" placeholder="Buscar por DNI..." />
        </div>

        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="buscarBtn" onclick="generarTablaAlquileres()">
            Buscar
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-secondary" id="borrarFiltrosBtn" onclick="borrarFiltros()">
            Borrar Filtros
          </button>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <table id="tabla-alquileres" class="table table-bordered">
            <thead>
              <tr>
                <th>Apellido y Nombres</th>
                <th>DNI</th>
                <th>Fecha de Alquiler</th>
                <th>Fecha de Devolución</th>
                <th>Precio</th>
                <th>Depósito</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="listaAlquileres"></tbody>
          </table>
        </div>
      </div>
    </form>
  </div>

  <script>
    var tabla;
    var id__cliente = -1;

    function generarTablaAlquileres() {
      let fechaInicio = $('#fechaInicio').val();
      let fechaFin = $('#fechaFin').val();
      let datos = {};

      if ((fechaInicio && !fechaFin) || (!fechaInicio && fechaFin)) {
        alert("Debe proporcionar tanto la fecha de inicio como la fecha de fin.");
        return;
      }
      if (fechaInicio && fechaFin) {
        if (fechaInicio > fechaFin) {
          alert("La fecha de inicio debe ser anterior a la fecha final.");
          return;
        }

        datos.fechaInicio = fechaInicio;
        datos.fechaFin = fechaFin;
      }

      let filtroDNI = $('#dniBusqueda').val();

      if (filtroDNI) {
        datos.filtroDNI = filtroDNI;
      }

      if (tabla != undefined) tabla.destroy();

      tabla = $('#tabla-alquileres').DataTable({
        ajax: {
          url: 'ajax/alquiler/generarListaAlquileres.php',
          type: 'POST',
          data: datos,
          error: function (xhr, error, thrown) {
            alert("Error en la operación.");
          }
        },
        language: {
          emptyTable: "No hay datos para mostrar.",
          info: "Mostrando _START_ a _END_ de _TOTAL_ alquileres",
          infoEmpty: "Mostrando 0 a 0 de 0 alquileres",
          infoFiltered: "(filtrando de un total de _MAX_ alquileres)",
          zeroRecords: "No hay datos para mostrar.",
          loadingRecords: "Cargando...",
          lengthMenu: "Cargar _MENU_ alquileres",
          search: "Buscar:",
          paginate: {
            first: "Primera",
            last: "Última",
            next: "Siguiente",
            previous: "Anterior"
          },
          aria: {
            sortAscending: ": activar para ordenar columna de manera ascendente",
            sortDescending: ": activar para ordenar columna de manera descendente"
          }
        },
        searching: false,
        autoWidth: false,
        order: [[2, "desc"]],
        columns: [
          { width: "25%" },
          { width: "10%" },
          { width: "10%" },
          { width: "10%" },
          { width: "10%" },
          { width: "10%" },
          {
            width: "25%",
            createdCell: function (td, cellData, rowData, row, col) {
              $(td).addClass('text-center');
            }
          }
        ]
      });
    }

    function borrarFiltros() {
      $('#dniBusqueda').val('');
      $('#fechaInicio').val('');
      $('#fechaFin').val('');
      generarTablaAlquileres();
    }

    function borrarAlquiler(event, idAlquiler) {
      event.preventDefault();
      console.log(idAlquiler);

      let datos = "idAlquiler=" + idAlquiler;

      if (confirm("¿Desea borrar el alquiler?")) {
        $.ajax({
          type: 'POST',
          url: 'ajax/alquiler/borrarAlquiler.php',
          data: datos,
          dataType: 'json',
          success: function (data) {
            if (data.estado == 1) {
              alert('Alquiler borrado correctamente.');
              borrarFiltros();
            } else if (data.estado == 2) {
              alert("Ha ocurrido un durante la operación.");
            }
          },
          error: function () {
            alert("Ha ocurrido un durante la operación.");
          }
        });
      }
    }

    $(document).ready(function () {
      $('input[type="text"]').val('');
      $('input[type="date"]').val('');
      generarTablaAlquileres();

      $('#dniBusqueda, #fechaInicio, #fechaFin').on('keypress', function (e) {
        if (e.which == 13) {
          e.preventDefault();
          generarTablaAlquileres();
        }
      });

      $('#buscarBtn').on('click', function () {
        generarTablaAlquileres();
      });
    });
    adjustSidebarWidth(250)
  </script>
</body>

</html>