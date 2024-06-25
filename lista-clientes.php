<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clientes</title>
    <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css" />
    <script src="assets/includes/js/jquery-3.7.1.min.js"></script>
    <script defer src="assets/includes/js/bootstrap.bundle.min.js"></script>

    <style>
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
    <div class="container mt-5">
      <h1 class="text-center">Clientes</h1>
      <div class="row">
        <div class="col-md-3">
          <input
            type="text"
            id="searchName"
            class="form-control"
            placeholder="Buscar por nombre o apellido..."
          />
        </div>
        <div class="col-md-3">
          <input
            type="text"
            id="searchDNI"
            class="form-control"
            placeholder="Buscar por DNI..."
          />
        </div>
        <div class="col-md-1">
          <button class="btn btn-primary" id="searchBtn">Buscar</button>
        </div>
        <div class="col-md-2">
          <button class="btn btn-secondary move-left" id="clearFiltersBtn">
            Borrar Filtros
          </button>
        </div>
        <div class="col-md-3">
          <button
            class="btn btn-success btn-lg-custom"
            id="addClientBtn"
            data-toggle="modal"
            data-target="#addModal"
          >
            Agregar Cliente
          </button>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <table class="table table-bordered">
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
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="editModal"
      tabindex="-1"
      aria-labelledby="editModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Editar Persona</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
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
            </button>
            <button type="button" class="btn btn-primary" id="saveChanges">
              Guardar Cambios
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Agregar -->
    <div
      class="modal fade"
      id="addModal"
      tabindex="-1"
      aria-labelledby="addModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Agregar Cliente</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
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
            <button type="button" class="btn btn-primary" id="addClient">
              Agregar Cliente
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- scripts -->
    <script>
      $(document).ready(function () {
        let people = [
          {
            id: 1,
            apellido: "Pérez",
            nombre: "Juan",
            dni: "12345678",
            email: "juan@example.com",
            telefono: "111-222-333",
            direccion: "Calle 1",
          },
          {
            id: 2,
            apellido: "Gómez",
            nombre: "María",
            dni: "87654321",
            email: "maria@example.com",
            telefono: "444-555-666",
            direccion: "Calle 2",
          },
          {
            id: 3,
            apellido: "Rodríguez",
            nombre: "Luis",
            dni: "11223344",
            email: "luis@example.com",
            telefono: "777-888-999",
            direccion: "Calle 3",
          },
          {
            id: 4,
            apellido: "Martínez",
            nombre: "Ana",
            dni: "55667788",
            email: "ana@example.com",
            telefono: "333-222-111",
            direccion: "Calle 4",
          },
          {
            id: 5,
            apellido: "López",
            nombre: "Carlos",
            dni: "99887766",
            email: "carlos@example.com",
            telefono: "555-444-333",
            direccion: "Calle 5",
          },
        ];

        function renderList(filterName = "", filterDNI = "") {
          const list = $("#person-list");
          list.empty();
          people.forEach((person) => {
            if (
              (person.apellido
                .toLowerCase()
                .includes(filterName.toLowerCase()) ||
                person.nombre
                  .toLowerCase()
                  .includes(filterName.toLowerCase())) &&
              person.dni.includes(filterDNI)
            ) {
              list.append(`
                            <tr>
                                <td>${person.apellido} ${person.nombre}</td>
                                <td>${person.dni}</td>
                                <td>${person.telefono}</td>
                                <td>${person.direccion}</td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-primary edit-btn" data-id="${person.id}">Editar</button>
                                    <button class="btn btn-danger delete-btn" data-id="${person.id}">Eliminar</button>
                                </td>
                            </tr>
                        `);
            }
          });

          // Detectar enter en los campos de búsqueda
          $("#searchName").keypress(function (event) {
            if (event.keyCode === 13) {
              $("#searchBtn").click();
            }
          });

          $("#searchDNI").keypress(function (event) {
            if (event.keyCode === 13) {
              $("#searchBtn").click();
            }
          });
        }

        $("#searchBtn").click(function () {
          const filterName = $("#searchName").val();
          const filterDNI = $("#searchDNI").val();
          renderList(filterName, filterDNI);
        });

        $("#clearFiltersBtn").click(function () {
          $("#searchName").val("");
          $("#searchDNI").val("");
          renderList();
        });

        $(document).on("click", ".edit-btn", function () {
          const id = $(this).data("id");
          const person = people.find((p) => p.id === id);
          if (person) {
            $("#editId").val(person.id);
            $("#editApellido").val(person.apellido);
            $("#editNombre").val(person.nombre);
            $("#editDNI").val(person.dni);
            $("#editEmail").val(person.email);
            $("#editTelefono").val(person.telefono);
            $("#editDireccion").val(person.direccion);
            $("#editModal").modal("show");
          }
        });

        $("#saveChanges").click(function () {
          const id = $("#editId").val();
          const person = people.find((p) => p.id == id);
          if (person) {
            person.apellido = $("#editApellido").val();
            person.nombre = $("#editNombre").val();
            person.dni = $("#editDNI").val();
            person.email = $("#editEmail").val();
            person.telefono = $("#editTelefono").val();
            person.direccion = $("#editDireccion").val();
            $("#editModal").modal("hide");
            renderList();
          }
        });

        $(document).on("click", ".delete-btn", function () {
          const id = $(this).data("id");
          people = people.filter((p) => p.id !== id);
          renderList();
        });

        $("#addClient").click(function () {
          const newPerson = {
            id: people.length ? people[people.length - 1].id + 1 : 1,
            apellido: $("#addApellido").val(),
            nombre: $("#addNombre").val(),
            dni: $("#addDNI").val(),
            email: $("#addEmail").val(),
            telefono: $("#addTelefono").val(),
            direccion: $("#addDireccion").val(),
          };
          console.log("Adding new client:", newPerson);
          people.push(newPerson);
          $("#addModal").modal("hide");
          renderList();
          $("#addForm")[0].reset();
        });

        $("#addClientBtn").click(function () {
          $("#addForm")[0].reset();
          $("#addModal").modal("show");
        });

        renderList();
      });
    </script>
  </body>
</html>
