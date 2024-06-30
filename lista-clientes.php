<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clientes</title>
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
      padding: 20px 35px;
      font-size: 1.5rem;
    }

    .move-left {
      margin-left: -15px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form class="custom-form" id="resizable-form">
      <h1 class="text-center">Clientes</h1>
      <div class="row">
        <div class="col-md-3">
          <input type="text" id="searchName" class="form-control" placeholder="Buscar por nombre o apellido..." />
        </div>
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
        <div class="col-md-3">
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
                <th>Apellido y Nombre</th>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Persona</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="form-group">
              <label for="editApellido">Apellido</label>
              <input type="text" class="form-control" id="editApellido" />
            </div>
            <div class="form-group">
              <label for="editNombre">Nombre</label>
              <input type="text" class="form-control" id="editNombre" />
            </div>
            <div class="form-group">
              <label for="editDNI">DNI</label>
              <input type="text" class="form-control" id="editDNI" />
            </div>
            <div class="form-group">
              <label for="editEmail">Correo Electrónico</label>
              <input type="email" class="form-control" id="editEmail" />
            </div>
            <div class="form-group">
              <label for="editTelefono">Número de Teléfono</label>
              <input type="text" class="form-control" id="editTelefono" />
            </div>
            <div class="form-group">
              <label for="editDireccion">Dirección</label>
              <input type="text" class="form-control" id="editDireccion" />
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Agregar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addForm">
            <div class="form-group">
              <label for="addApellido">Apellido</label>
              <input type="text" class="form-control" id="addApellido" />
            </div>
            <div class="form-group">
              <label for="addNombre">Nombre</label>
              <input type="text" class="form-control" id="addNombre" />
            </div>
            <div class="form-group">
              <label for="addDNI">DNI</label>
              <input type="text" class="form-control" id="addDNI" />
            </div>
            <div class="form-group">
              <label for="addEmail">Correo Electrónico</label>
              <input type="email" class="form-control" id="addEmail" />
            </div>
            <div class="form-group">
              <label for="addTelefono">Número de Teléfono</label>
              <input type="text" class="form-control" id="addTelefono" />
            </div>
            <div class="form-group">
              <label for="addDireccion">Dirección</label>
              <input type="text" class="form-control" id="addDireccion" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addClient" onclick="agregarCliente()">
            Agregar Cliente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- scripts -->
  <script>
    var tabla;
    var id__cliente = -1;

    function generarTablaClientes() {
      if (tabla != undefined) tabla.destroy();

      // let filtroNombre = $('#searchName').val();
      let filtroDNI = $('#searchDNI').val();

      let datos = {};
      if (filtroDNI) {
        datos = { "filtroDNI": filtroDNI };
      }

      tabla = $('#client-table').DataTable({
        ajax: {
          url: 'ajax/cliente/generarListaClientes.php',
          type: 'POST',
          data: datos,
          error: function (xhr, error, thrown) {
            alert("Error en la operación.");
          }
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
            previous: "Anterior"
          },
          aria: {
            sortAscending: ": activar para ordenar columna de manera ascendete",
            sortDescending: ": activar para ordenar columna de manera descendente"
          }
        },
        searching: false,
        autoWidth: false,
        columns: [
          { width: "25%" },
          { width: "10%" },
          { width: "13%" },
          { width: "30%" },
          {
            width: "22%",
            createdCell: function (td, cellData, rowData, row, col) {
              $(td).addClass('text-center');
            }
          }
        ]
      });
    }

    function borrarFiltros() {
      $('#searchDNI').val('');
      generarTablaClientes();
    }

    function agregarCliente() {
      let apellidos = $('#addApellido').val().trim();
      let nombres = $('#addNombre').val().trim();
      let dni = $('#addDNI').val().trim();
      let correo = $('#addEmail').val().trim();
      let telefono = $('#addTelefono').val().trim();
      let domicilio = $('#addDireccion').val().trim();

      if (apellidos === '' || nombres === '' || dni === '' || telefono === '' || domicilio === '') {
        alert("Faltan cargar datos.");
        return;
      }

      let datos = "apellidos=" + apellidos + "&nombres=" + nombres + "&numero_documento=" + dni + "&correo=" + correo + "&telefono=" + telefono + "&domicilio=" + domicilio + "&accion=guardar";

      $.ajax({
        type: 'POST',
        url: 'ajax/cliente/registrarCliente.php',
        data: datos,
        dataType: 'json',
        success: function (data) {
          if (data.estado == 1) {
            alert('Cliente registrado correctamente.');
            $('#addModal').modal('hide');
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

    function clickEditar(event, idCliente, apellidos, nombres, numero_documento, correo, telefono, domicilio) {
      event.preventDefault();

      $('#editApellido').val(apellidos),
        $('#editNombre').val(nombres),
        $('#editDNI').val(numero_documento),
        $('#editEmail').val(correo),
        $('#editTelefono').val(telefono),
        $('#editDireccion').val(domicilio)
      id__cliente = idCliente;

      $('#editModal').modal('show');
    }

    function editarCliente() {
      apellidos = $('#editApellido').val().trim();
      nombres = $('#editNombre').val().trim();
      dni = $('#editDNI').val().trim();
      correo = $('#editEmail').val().trim();
      telefono = $('#editTelefono').val().trim();
      domicilio = $('#editDireccion').val().trim();

      if (apellidos === '' || nombres === '' || dni === '' || telefono === '' || domicilio === '') {
        alert("Faltan cargar datos.");
        return;
      }

      let datos = "idCliente=" + id__cliente + "&apellidos=" + apellidos + "&nombres=" + nombres + "&numero_documento=" + dni + "&correo=" + correo + "&telefono=" + telefono + "&domicilio=" + domicilio + "&accion=editar";

      $.ajax({
        type: 'POST',
        url: 'ajax/cliente/registrarCliente.php',
        data: datos,
        dataType: 'json',
        success: function (data) {
          if (data.estado == 1) {
            $('#searchDNI').val(dni);
            generarTablaClientes();
            alert('Los cambios se han realizado correctamente.');
            $('#editModal').modal('hide');
            id__cliente = -1;
          } else if (data.estado == 2) {
            alert("Ha ocurrido un durante la operación.");
          }
        },
        error: function () {
          alert("Ha ocurrido un durante la operación.");
        }
      });
    }

    function borrarCliente(event, idCliente, apellidos, nombres) {
      event.preventDefault();

      let datos = "idCliente=" + idCliente;

      if (confirm("¿Desea borrar al cliente " + apellidos + ", " + nombres + "?")) {
        $.ajax({
          type: 'POST',
          url: 'ajax/cliente/borrarCliente.php',
          data: datos,
          dataType: 'json',
          success: function (data) {
            if (data.estado == 1) {
              alert('Cliente borrado correctamente.');
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

      generarTablaClientes();

      // #############################################

      // let people = [
      //   {
      //     id: 1,
      //     apellido: "Pérez",
      //     nombre: "Juan",
      //     dni: "12345678",
      //     email: "juan@example.com",
      //     telefono: "111-222-333",
      //     direccion: "Calle 1",
      //   },
      //   {
      //     id: 2,
      //     apellido: "Gómez",
      //     nombre: "María",
      //     dni: "87654321",
      //     email: "maria@example.com",
      //     telefono: "444-555-666",
      //     direccion: "Calle 2",
      //   },
      //   {
      //     id: 3,
      //     apellido: "Rodríguez",
      //     nombre: "Luis",
      //     dni: "11223344",
      //     email: "luis@example.com",
      //     telefono: "777-888-999",
      //     direccion: "Calle 3",
      //   },
      //   {
      //     id: 4,
      //     apellido: "Martínez",
      //     nombre: "Ana",
      //     dni: "55667788",
      //     email: "ana@example.com",
      //     telefono: "333-222-111",
      //     direccion: "Calle 4",
      //   },
      //   {
      //     id: 5,
      //     apellido: "López",
      //     nombre: "Carlos",
      //     dni: "99887766",
      //     email: "carlos@example.com",
      //     telefono: "555-444-333",
      //     direccion: "Calle 5",
      //   },
      // ];

      // function renderList(filterName = "", filterDNI = "") {
      //   const list = $("#person-list");
      //   list.empty();
      //   people.forEach((person) => {
      //     if (
      //       (person.apellido
      //         .toLowerCase()
      //         .includes(filterName.toLowerCase()) ||
      //         person.nombre
      //           .toLowerCase()
      //           .includes(filterName.toLowerCase())) &&
      //       person.dni.includes(filterDNI)
      //     ) {
      //       list.append(`
      //               <tr>
      //                   <td>${person.apellido} ${person.nombre}</td>
      //                   <td>${person.dni}</td>
      //                   <td>${person.telefono}</td>
      //                   <td>${person.direccion}</td>
      //                   <td class="text-center align-middle">
      //                       <button class="btn btn-primary edit-btn" data-id="${person.id}">Editar</button>
      //                       <button class="btn btn-danger delete-btn" data-id="${person.id}">Eliminar</button>
      //                   </td>
      //               </tr>
      //           `);
      //     }
      //   });
      // }

      //   function handleSearch() {
      //     const filterName = $("#searchName").val();
      //     const filterDNI = $("#searchDNI").val();
      //     renderList(filterName, filterDNI);
      //   }

      //   $("#searchName").keypress(function (event) {
      //     if (event.keyCode === 13) {
      //       event.preventDefault();
      //       handleSearch();
      //     }
      //   });

      //   $("#searchDNI").keypress(function (event) {
      //     if (event.keyCode === 13) {
      //       event.preventDefault();
      //       handleSearch();
      //     }
      //   });

      //   $("#searchBtn").click(function () {
      //     handleSearch();
      //   });

      //   $("#clearFiltersBtn").click(function () {
      //     $("#searchName").val("");
      //     $("#searchDNI").val("");
      //     renderList();
      //   });

      //   $(document).on("click", ".edit-btn", function () {
      //     event.preventDefault();
      //     const id = $(this).data("id");
      //     const person = people.find((p) => p.id == id);
      //     if (person) {
      //       $("#editId").val(person.id);
      //       $("#editApellido").val(person.apellido);
      //       $("#editNombre").val(person.nombre);
      //       $("#editDNI").val(person.dni);
      //       $("#editEmail").val(person.email);
      //       $("#editTelefono").val(person.telefono);
      //       $("#editDireccion").val(person.direccion);
      //       $("#editModal").modal("show");
      //     }
      //   });

      //   $("#saveChanges").click(function () {
      //     event.preventDefault();
      //     const id = $("#editId").val();
      //     const person = people.find((p) => p.id == id);
      //     if (person) {
      //       person.apellido = $("#editApellido").val();
      //       person.nombre = $("#editNombre").val();
      //       person.dni = $("#editDNI").val();
      //       person.email = $("#editEmail").val();
      //       person.telefono = $("#editTelefono").val();
      //       person.direccion = $("#editDireccion").val();
      //       $("#editModal").modal("hide");
      //       renderList();
      //     }
      //   });

      //   $(document).on("click", ".delete-btn", function () {
      //     const id = $(this).data("id");
      //     people = people.filter((p) => p.id !== id);
      //     renderList();
      //   });

      //   $("#addClient").click(function () {
      //     const newPerson = {
      //       id: people.length ? people[people.length - 1].id + 1 : 1,
      //       apellido: $("#addApellido").val(),
      //       nombre: $("#addNombre").val(),
      //       dni: $("#addDNI").val(),
      //       email: $("#addEmail").val(),
      //       telefono: $("#addTelefono").val(),
      //       direccion: $("#addDireccion").val(),
      //     };
      //     people.push(newPerson);
      //     $("#addModal").modal("hide");
      //     renderList();
      //     $("#addForm")[0].reset();
      //   });

      //   $("#addClientBtn").click(function () {
      //     $("#addForm")[0].reset();
      //     $("#addModal").modal("show");
      //   });

      //   renderList();
    });
  </script>
</body>

</html>
