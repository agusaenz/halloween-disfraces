<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de Alquileres</title>
    <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css" />
    <script defer src="assets/includes/js/bootstrap.bundle.min.js"></script>
    <script src="assets/includes/js/jquery-3.7.1.min.js"></script>
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
    </style>
  </head>

  <body>
    <div class="container">
      <form class="custom-form" id="resizable-form">
        <h1 class="text-center">Lista de Alquileres</h1>
        <div class="row">
          <div class="col-md-3">
            <input
              type="text"
              id="nombreBusqueda"
              class="form-control"
              placeholder="Buscar por nombre o apellido..."
            />
          </div>
          <div class="col-md-3">
            <input
              type="text"
              id="dniBusqueda"
              class="form-control"
              placeholder="Buscar por DNI..."
            />
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary" id="buscarBtn">
              Buscar
            </button>
          </div>
          <div class="col-md-2">
            <button
              type="button"
              class="btn btn-secondary"
              id="borrarFiltrosBtn"
            >
              Borrar Filtros
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
      $(document).ready(function () {
        let alquileres = [
          {
            id: 1,
            nombreCliente: "Messi Mateo",
            dni: "12345678",
            fechaAlquiler: "2024-01-01",
            fechaDevolucion: "2024-01-07",
            precio: "$15000",
            deposito: "$5000",
          },
          {
            id: 2,
            nombreCliente: "Giudice Juan",
            dni: "23456789",
            fechaAlquiler: "2024-02-15",
            fechaDevolucion: "2024-02-20",
            precio: "$7500",
            deposito: "$2500",
          },
          {
            id: 3,
            nombreCliente: "Rodriguez Lucas",
            dni: "34567890",
            fechaAlquiler: "2024-03-10",
            fechaDevolucion: "2024-03-15",
            precio: "$8000",
            deposito: "$3000",
          },
          {
            id: 4,
            nombreCliente: "Pablo",
            dni: "45678901",
            fechaAlquiler: "2024-04-05",
            fechaDevolucion: "2024-04-10",
            precio: "$25",
            deposito: "$10",
          },
          {
            id: 5,
            nombreCliente: "Morales Evon",
            dni: "56789012",
            fechaAlquiler: "2024-05-01",
            fechaDevolucion: "2024-05-05",
            precio: "$53",
            deposito: "$20",
          },
        ];

        function mostrarListaAlquileres(filtroNombre = "", filtroDNI = "") {
          const lista = $("#listaAlquileres");
          lista.empty();
          alquileres.forEach((alquiler) => {
            if (
              alquiler.nombreCliente
                .toLowerCase()
                .includes(filtroNombre.toLowerCase()) &&
              alquiler.dni.includes(filtroDNI)
            ) {
              lista.append(`
                <tr data-id="${alquiler.id}">
                    <td>${alquiler.nombreCliente}</td>
                    <td>${alquiler.dni}</td>
                    <td>${alquiler.fechaAlquiler}</td>
                    <td>${alquiler.fechaDevolucion}</td>
                    <td>${alquiler.precio}</td>
                    <td>${alquiler.deposito}</td>
                    <td class="text-center">
                        <button class="btn btn-primary verAlquilerBtn" data-id="${alquiler.id}">Ver</button>
                        <button class="btn btn-danger eliminarAlquilerBtn ml-2" data-id="${alquiler.id}">Eliminar</button>
                    </td>
                </tr>
              `);
            }
          });
        }

        function buscarAlquiler() {
          const filtroNombre = $("#nombreBusqueda").val().trim();
          const filtroDNI = $("#dniBusqueda").val().trim();
          mostrarListaAlquileres(filtroNombre, filtroDNI);
        }

        $("#buscarBtn").click(buscarAlquiler);

        $("#nombreBusqueda, #dniBusqueda").keypress(function (e) {
          if (e.which == 13) {
            e.preventDefault();
            buscarAlquiler();
          }
        });

        $("#borrarFiltrosBtn").click(function () {
          $("#nombreBusqueda").val("");
          $("#dniBusqueda").val("");
          mostrarListaAlquileres();
        });

        mostrarListaAlquileres();

        $(document).on("click", ".verAlquilerBtn", function () {
          const alquilerId = $(this).data("id");
          alert(`Ver alquiler ${alquilerId}`);
        });

        $(document).on("click", ".eliminarAlquilerBtn", function () {
          const alquilerId = $(this).data("id");
          alquileres = alquileres.filter(
            (alquiler) => alquiler.id !== alquilerId
          );
          mostrarListaAlquileres();
        });
      });
    </script>
  </body>
</html>
