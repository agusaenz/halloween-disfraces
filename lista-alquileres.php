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

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #b39b9b;
      font-family: "Roboto", sans-serif;
      font-size: 0.9rem;
      margin: 0;
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
      max-height: 900px;
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
  </style>
</head>

<body>
  <div class="container">
    <form class="custom-form" id="resizable-form">
      <h1 class="text-center">Lista de Alquileres</h1>
      <div class="row">
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
      if (tabla != undefined) tabla.destroy();

      let filtroDNI = $('#dniBusqueda').val();

      let datos = {};
      if (filtroDNI) {
        datos = {
          "filtroDNI": filtroDNI
        };
      }

      tabla = $('#tabla-alquileres').DataTable({
        ajax: {
          url: 'ajax/alquiler/generarListaAlquileres.php',
          type: 'POST',
          data: datos,
          error: function(xhr, error, thrown) {
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
            sortAscending: ": activar para ordenar columna de manera ascendete",
            sortDescending: ": activar para ordenar columna de manera descendente"
          }
        },
        searching: false,
        autoWidth: false,
        order: [[2]],
        columns: [{
            width: "25%"
          },
          {
            width: "10%"
          },
          {
            width: "10%"
          },
          {
            width: "10%"
          },
          {
            width: "10%"
          },
          {
            width: "10%"
          },
          {
            width: "25%",
            createdCell: function(td, cellData, rowData, row, col) {
              $(td).addClass('text-center');
            }
          }
        ]
      });
    }

    function borrarFiltros() {
      $('#dniBusqueda').val('');
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
          success: function(data) {
            if (data.estado == 1) {
              alert('Alquiler borrado correctamente.');
              borrarFiltros();
            } else if (data.estado == 2) {
              alert("Ha ocurrido un durante la operación.");
            }
          },
          error: function() {
            alert("Ha ocurrido un durante la operación.");
          }
        });
      }
    }

    $(document).ready(function() {
      $('input[type="text"]').val('');
      generarTablaAlquileres();

      $('#dniBusqueda').on('keypress', function (e) {
        if (e.which == 13) {
          e.preventDefault();
          generarTablaAlquileres();
        }
      });
    });
  </script>
</body>

</html>