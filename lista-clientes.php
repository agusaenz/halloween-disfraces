<?php
require_once ('sidebar.php');
include 'ajax/auth.php';

$__numero_documento = 0;
if (isset($_GET["__numero_documento"]) && is_numeric($_GET["__numero_documento"])) {
  $__numero_documento = filter_input(INPUT_GET, '__numero_documento', FILTER_SANITIZE_NUMBER_INT);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clientes</title>
  <link rel="icon" href="assets/img/icon.png">
  <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/includes/DataTables/datatables.min.css" />
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
      overflow-y: auto;
    }

    .btn-lg-custom {
      padding: 20px 35px;
      font-size: 1.5rem;
    }

    .move-left {
      margin-left: -15px;
    }

    .modal-body {
      max-height: 70vh;
      overflow-y: auto;
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

    .form-group label {
      font-size: 1.1rem;
      font-weight: bold;
    }

    .modal-body .form-group {
      margin-bottom: 20px;
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
    <form class="custom-form" id="resizable-form">
      <h1 class="text-center">Clientes</h1>
      <div class="row">
        <div class="col-md-3">
          <input type="text" id="searchDNI" class="form-control" placeholder="Buscar por DNI..." />
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="searchBtn" onclick="generarTablaClientes()">
            Buscar
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-secondary move-left" id="clearFiltersBtn" onclick="borrarFiltros();">
            Borrar Filtros
          </button>
        </div>
        <div class="col-md-3 ms-auto">
          <button type="button" class="btn btn-success btn-lg-custom" id="addClientBtn" data-bs-toggle="modal"
            data-bs-target="#addModal">
            Agregar Cliente
          </button>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <table id="client-table" class="table table-bordered">
            <thead>
              <tr>
                <th>Apellido y Nombres</th>
                <th>DNI</th>
                <th>Telefono</th>
                <th>Domicilio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="person-list"></tbody>
          </table>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Datos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="editApellido" class="fw-bold fs-6">Apellido</label>
                <input type="text" class="form-control" id="editApellido" />
              </div>
              <div class="col-md-6">
                <label for="editNombre" class="fw-bold fs-6">Nombres</label>
                <input type="text" class="form-control" id="editNombre" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="editDNI" class="fw-bold fs-6">DNI</label>
                <input type="text" class="form-control" id="editDNI" />
              </div>
              <div class="col-md-6">
                <label for="editEmail" class="fw-bold fs-6">Correo Electrónico</label>
                <input type="email" class="form-control" id="editEmail" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="editTelefono" class="fw-bold fs-6">Número de Teléfono</label>
                <input type="text" class="form-control" id="editTelefono" />
              </div>
              <div class="col-md-6">
                <label for="editDireccion" class="fw-bold fs-6">Domicilio</label>
                <input type="text" class="form-control" id="editDireccion" />
              </div>
            </div>
            <input type="hidden" id="editId" />
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveChanges" onclick="editarCliente()">
            Guardar Cambios
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Agregar -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Agregar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addForm">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="addApellido" class="fw-bold fs-6">Apellido</label>
                <input type="text" class="form-control" id="addApellido" />
              </div>
              <div class="col-md-6">
                <label for="addNombre" class="fw-bold fs-6">Nombres</label>
                <input type="text" class="form-control" id="addNombre" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="addDNI" class="fw-bold fs-6">DNI</label>
                <input type="text" class="form-control" id="addDNI" />
              </div>
              <div class="col-md-6">
                <label for="addEmail" class="fw-bold fs-6">Correo Electrónico</label>
                <input type="email" class="form-control" id="addEmail" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="addTelefono" class="fw-bold fs-6">Número de Teléfono</label>
                <input type="text" class="form-control" id="addTelefono" />
              </div>
              <div class="col-md-6">
                <label for="addDireccion" class="fw-bold fs-6">Domicilio</label>
                <input type="text" class="form-control" id="addDireccion" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addClient" onclick="agregarCliente()">
            Agregar Cliente
          </button>
          <button type="button" class="btn btn-success" id="rentalBtn" onclick="hacerAlquiler()" style="display: none">
            Hacer Alquiler
          </button>
        </div>
      </div>
    </div>
  </div>


  <!-- scripts -->
  <script>
    var tabla;
    var id__cliente = -1;
    var __numero_documento = <?php echo $__numero_documento; ?>;

    function generarTablaClientes() {
      if (tabla != undefined) tabla.destroy();

      let filtroDNI = $("#searchDNI").val();

      let datos = {};
      if (filtroDNI) {
        datos = {
          filtroDNI: filtroDNI,
        };
      }

      tabla = $("#client-table").DataTable({
        ajax: {
          url: "ajax/cliente/generarListaClientes.php",
          type: "POST",
          data: datos,
          error: function (xhr, error, thrown) {
            alert("Error en la operación.");
          },
        },
        language: {
          emptyTable: "No hay datos para mostrar.",
          info: "Mostrando _START_ a _END_ de _TOTAL_ clientes",
          infoEmpty: "Mostrando 0 a 0 de 0 clientes",
          infoFiltered: "(filtrando de un total de _MAX_ clientes)",
          zeroRecords: "No hay datos para mostrar.",
          loadingRecords: "Cargando...",
          lengthMenu: "Cargar _MENU_ clientes",
          search: "Buscar:",
          paginate: {
            first: "Primera",
            last: "Última",
            next: "Siguiente",
            previous: "Anterior",
          },
          aria: {
            sortAscending:
              ": activar para ordenar columna de manera ascendete",
            sortDescending:
              ": activar para ordenar columna de manera descendente",
          },
        },
        searching: false,
        autoWidth: false,
        order: [],
        columns: [
          { width: "23%", },
          { width: "7%", },
          { width: "10%", },
          { width: "30%", },
          {
            width: "30%",
            createdCell: function (td, cellData, rowData, row, col) {
              $(td).addClass("text-center");
            },
          },
        ],
      });
    }

    function borrarFiltros() {
      $("#searchDNI").val("");
      generarTablaClientes();
    }

    function agregarCliente() {
      let apellidos = $("#addApellido").val().trim();
      let nombres = $("#addNombre").val().trim();
      let dni = $("#addDNI").val().trim();
      let correo = $("#addEmail").val().trim();
      let telefono = $("#addTelefono").val().trim();
      let domicilio = $("#addDireccion").val().trim();

      if (apellidos === "" || nombres === "" || dni === "" || telefono === "" || domicilio === "") {
        alert("Faltan cargar datos.");
        return;
      }

      let datos = "apellidos=" + apellidos + "&nombres=" + nombres + "&numero_documento=" + dni + "&correo=" + correo + "&telefono=" + telefono + "&domicilio=" + domicilio + "&accion=guardar";

      $.ajax({
        type: "POST",
        url: "ajax/cliente/registrarCliente.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          if (data.estado == 1) {
            alert("Cliente registrado correctamente.");
            $("#rentalBtn").show();
            $("#addClient").prop("disabled", true);
            borrarFiltros();
          } else if (data.estado == 2) {
            alert("Ha ocurrido un error durante la operación.");
          } else if (data.estado == 0) {
            alert(data.mensaje);
          }
        },
        error: function () {
          alert("Ha ocurrido un error durante la operación.");
        },
      });
    }

    function clickEditar(event, idCliente, apellidos, nombres, numero_documento, correo, telefono, domicilio) {
      event.preventDefault();

      $("#editApellido").val(apellidos),
        $("#editNombre").val(nombres),
        $("#editDNI").val(numero_documento),
        $("#editEmail").val(correo),
        $("#editTelefono").val(telefono),
        $("#editDireccion").val(domicilio);
      id__cliente = idCliente;

      $("#editModal").modal("show");
    }

    function editarCliente() {
      apellidos = $("#editApellido").val().trim();
      nombres = $("#editNombre").val().trim();
      dni = $("#editDNI").val().trim();
      correo = $("#editEmail").val().trim();
      telefono = $("#editTelefono").val().trim();
      domicilio = $("#editDireccion").val().trim();

      if (apellidos === "" || nombres === "" || dni === "" || telefono === "" || domicilio === "") {
        alert("Faltan cargar datos.");
        return;
      }

      let datos = "idCliente=" + id__cliente + "&apellidos=" + apellidos + "&nombres=" + nombres + "&numero_documento=" + dni + "&correo=" + correo + "&telefono=" + telefono + "&domicilio=" + domicilio + "&accion=editar";

      $.ajax({
        type: "POST",
        url: "ajax/cliente/registrarCliente.php",
        data: datos,
        dataType: "json",
        success: function (data) {
          if (data.estado == 1) {
            $("#searchDNI").val(dni);
            generarTablaClientes();
            alert("Los cambios se han realizado correctamente.");
            $("#editModal").modal("hide");
            id__cliente = -1;
          } else if (data.estado == 2) {
            alert("Ha ocurrido un durante la operación.");
          }
        },
        error: function () {
          alert("Ha ocurrido un durante la operación.");
        },
      });
    }

    function borrarCliente(event, idCliente, apellidos, nombres) {
      event.preventDefault();

      let datos = "idCliente=" + idCliente;

      if (confirm("¿Desea borrar al cliente " + apellidos + ", " + nombres + "?")) {
        $.ajax({
          type: "POST",
          url: "ajax/cliente/borrarCliente.php",
          data: datos,
          dataType: "json",
          success: function (data) {
            if (data.estado == 1) {
              alert("Cliente borrado correctamente.");
              borrarFiltros();
            } else if (data.estado == 2) {
              alert("Ha ocurrido un durante la operación.");
            }
          },
          error: function () {
            alert("Ha ocurrido un durante la operación.");
          },
        });
      }
    }

    function hacerAlquiler() {
      let dni = $('#addDNI').val();
      window.location.href = 'carga-alquiler.php?__numero_documento=' + encodeURIComponent(dni);

      return false;
    }

    $(document).ready(function () {
      if (__numero_documento && __numero_documento != "" && __numero_documento != undefined) {
        $('#searchDNI').val(__numero_documento);
        generarTablaClientes();
      } else {
        $('input[type="text"]').val("");
        generarTablaClientes();
      }

      $("#searchDNI").on("keypress", function (e) {
        if (e.which == 13) {
          e.preventDefault();
          generarTablaClientes();
        }
      });

      $("#addModal").on("show.bs.modal", function () {
        resetAddForm();
        $("#rentalBtn").hide();
        $("#addClient").prop("disabled", false);
      });
    });

    function resetAddForm() {
      $("#addForm").trigger("reset");
    }

    adjustSidebarWidth(200)  
  </script>
</body>

</html>