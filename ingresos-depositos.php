<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administración</title>
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
        transition: border-color 0.3s ease;
      }
      .btn-lg-custom {
        padding: 10px 20px;
        font-size: 1.25rem;
        width: 100%;
      }
      .btn-group-toggle .btn {
        transition: background-color 0.3s ease;
      }
      .btn-group-toggle .btn.active {
        background-color: #007bff !important;
        color: white;
      }
      .total-section {
        background-color: #f8d7da;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <form class="custom-form" id="resizable-form">
        <h1 class="text-center">Administración</h1>
        <div class="row mb-4">
          <div class="col-md-6">
            <button
              type="button"
              class="btn btn-primary btn-lg-custom"
              id="ingresosBtn"
            >
              Ingresos
            </button>
          </div>
          <div class="col-md-6">
            <button
              type="button"
              class="btn btn-primary btn-lg-custom"
              id="depositosBtn"
            >
              Depósitos
            </button>
          </div>
        </div>

        <div id="filtersSection" style="display: none">
          <div class="row mb-3">
            <div class="col-md-4">
              <input
                type="date"
                id="fechaInicio"
                class="form-control"
                placeholder="Fecha inicio"
                lang="es"
              />
            </div>
            <div class="col-md-4">
              <input
                type="date"
                id="fechaFin"
                class="form-control"
                placeholder="Fecha fin"
                lang="es"
              />
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" id="filtrarBtn">
                Filtrar
              </button>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12 text-right">
              <div class="total-section">
                Total: <span id="totalMonto">$0</span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>DNI</th>
                    <th>Fecha de Reserva</th>
                    <th>Fecha de Devolución</th>
                    <th id="montoHeader">Monto</th>
                  </tr>
                </thead>
                <tbody id="listaTransacciones"></tbody>
              </table>
            </div>
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
            precio: 15000,
            deposito: 5000,
          },
          {
            id: 2,
            nombreCliente: "Giudice Juan",
            dni: "23456789",
            fechaAlquiler: "2024-02-15",
            fechaDevolucion: "2024-02-20",
            precio: 7500,
            deposito: 2500,
          },
          {
            id: 3,
            nombreCliente: "Rodriguez Lucas",
            dni: "34567890",
            fechaAlquiler: "2024-03-10",
            fechaDevolucion: "2024-03-15",
            precio: 8000,
            deposito: 3000,
          },
          {
            id: 4,
            nombreCliente: "Pablo",
            dni: "45678901",
            fechaAlquiler: "2024-04-05",
            fechaDevolucion: "2024-04-10",
            precio: 25,
            deposito: 10,
          },
          {
            id: 5,
            nombreCliente: "Morales Evon",
            dni: "56789012",
            fechaAlquiler: "2024-05-01",
            fechaDevolucion: "2024-05-05",
            precio: 53,
            deposito: 20,
          },
        ];

        let modo = "";

        function mostrarListaTransacciones(fechaInicio, fechaFin) {
          const lista = $("#listaTransacciones");
          lista.empty();
          let totalMonto = 0;

          alquileres.forEach((alquiler) => {
            const fechaReserva = new Date(alquiler.fechaAlquiler);
            const fechaDevolucion = new Date(alquiler.fechaDevolucion);
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);

            if (
              (fechaReserva >= inicio && fechaReserva <= fin) ||
              (fechaDevolucion >= inicio && fechaDevolucion <= fin)
            ) {
              const monto =
                modo === "ingresos" ? alquiler.precio : alquiler.deposito;
              totalMonto += monto;

              lista.append(`
                <tr>
                    <td>${alquiler.dni}</td>
                    <td>${alquiler.fechaAlquiler}</td>
                    <td>${alquiler.fechaDevolucion}</td>
                    <td>${monto}</td>
                </tr>
              `);
            }
          });

          $("#totalMonto").text(`$${totalMonto}`);
        }

        function filtrarTransacciones() {
          const fechaInicio = $("#fechaInicio").val();
          const fechaFin = $("#fechaFin").val();

          if (fechaInicio && fechaFin) {
            mostrarListaTransacciones(fechaInicio, fechaFin);
          } else {
            alert("Por favor, selecciona ambas fechas.");
          }
        }

        $("#filtrarBtn").click(filtrarTransacciones);

        $("#ingresosBtn").click(function () {
          modo = "ingresos";
          $("#ingresosBtn").addClass("active");
          $("#depositosBtn").removeClass("active");
          $("#filtersSection").show();
          $("#montoHeader").text("Ingreso");
          $("#totalMonto").text("$0");
          $("#listaTransacciones").empty();
          $("#fechaInicio").val("");
          $("#fechaFin").val("");
          $("h1").text("Ingresos");
        });

        $("#depositosBtn").click(function () {
          modo = "depositos";
          $("#depositosBtn").addClass("active");
          $("#ingresosBtn").removeClass("active");
          $("#filtersSection").show();
          $("#montoHeader").text("Depósito");
          $("#totalMonto").text("$0");
          $("#listaTransacciones").empty();
          $("#fechaInicio").val("");
          $("#fechaFin").val("");
          $("h1").text("Depósitos");
        });
      });
    </script>
  </body>
</html>
