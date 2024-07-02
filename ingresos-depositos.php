<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administración</title>
  <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/includes/DataTables/datatables.min.css" />
  <script defer src="assets/includes/js/bootstrap.bundle.min.js"></script>
  <script src="assets/includes/js/jquery-3.7.1.min.js"></script>
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
          <button type="button" class="btn btn-primary btn-lg-custom" id="ingresosBtn">
            Ingresos
          </button>
        </div>
        <div class="col-md-6">
          <button type="button" class="btn btn-primary btn-lg-custom" id="depositosBtn">
            Depósitos
          </button>
        </div>
      </div>

      <div id="filtersSection" style="display: none">
        <div class="row mb-3">
          <div class="col-md-4">
            <input type="date" id="fechaInicio" class="form-control" placeholder="Fecha inicio" lang="es" />
          </div>
          <div class="col-md-4">
            <input type="date" id="fechaFin" class="form-control" placeholder="Fecha fin" lang="es" />
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-primary" id="filtrarBtn" onclick="generarTablaMovimientos()">
              Buscar
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
            <table id="tabla-administracion" class="table table-bordered">
              <thead>
                <tr>
                  <th>DNI</th>
                  <th>Fecha de Alquiler</th>
                  <th>Fecha de Devolución</th>
                  <th>Forma de pago</th>
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
    var tabla, tipo;

    function generarTablaMovimientos() {
      let fechaInicio = $('#fechaInicio').val();
      let fechaFin = $('#fechaFin').val();
      if (!fechaInicio) {
        alert("Debe seleccionar una fecha de inicio.");
        return;
      }
      if (!fechaFin) {
        alert("Debe seleccionar una fecha final.");
        return;
      }

      if (fechaInicio > fechaFin) {
        alert("La fecha de inicio debe ser anterior a la fecha final.");
        return;
      }

      let datos = {
        fechaInicio: fechaInicio,
        fechaFin: fechaFin
      };
      if (tipo == "ingresos") {
        datos.tipo = "total";
      } else if (tipo == "depositos") {
        datos.tipo = "deposito";
      }

      if (tabla != undefined) tabla.destroy();

      tabla = $("#tabla-administracion").DataTable({
        ajax: {
          url: "ajax/administracion.php",
          type: "POST",
          data: datos,
          dataSrc: function(json) {
            $('#totalMonto').text("$" + json.total);
            console.log(json.total);

            return json.data;
          },
          error: function(xhr, error, thrown) {
            alert("Error en la operación.");
          },
        },
        language: {
          emptyTable: "No hay datos para mostrar.",
          info: "Mostrando _START_ a _END_ de _TOTAL_ movimientos",
          infoEmpty: "Mostrando 0 a 0 de 0 movimientos",
          infoFiltered: "(filtrando de un total de _MAX_ movimientos)",
          zeroRecords: "No hay datos para mostrar.",
          loadingRecords: "Cargando...",
          lengthMenu: "Cargar _MENU_ movimientos",
          search: "Buscar:",
          paginate: {
            first: "Primera",
            last: "Última",
            next: "Siguiente",
            previous: "Anterior",
          },
          aria: {
            sortAscending: ": activar para ordenar columna de manera ascendete",
            sortDescending: ": activar para ordenar columna de manera descendente",
          },
        },
        searching: false,
        autoWidth: false,
        order: [
          [1]
        ],
        columns: [{
            width: "20%",
          },
          {
            width: "20%",
          },
          {
            width: "20%",
          },
          {
            width: "20%",
          },
          {
            width: "20%",
          }
        ],
      });
    }

    $(document).ready(function() {
      $("#ingresosBtn").click(function() {
        $("#ingresosBtn").addClass("active");
        $("#depositosBtn").removeClass("active");
        $("#filtersSection").show();
        $("#montoHeader").text("Ingreso");
        $("#totalMonto").text("$0");
        $("#listaTransacciones").empty();
        $("#fechaInicio").val("");
        $("#fechaFin").val("");
        $("h1").text("Ingresos");
        tipo = "ingresos";
      });

      $("#depositosBtn").click(function() {
        $("#depositosBtn").addClass("active");
        $("#ingresosBtn").removeClass("active");
        $("#filtersSection").show();
        $("#montoHeader").text("Depósito");
        $("#totalMonto").text("$0");
        $("#listaTransacciones").empty();
        $("#fechaInicio").val("");
        $("#fechaFin").val("");
        $("h1").text("Depósitos");
        tipo = "depositos";
      });
    });

    // let alquileres = [{
    //     id: 1,
    //     nombreCliente: "Messi Mateo",
    //     dni: "12345678",
    //     fechaAlquiler: "2024-01-01",
    //     fechaDevolucion: "2024-01-07",
    //     precio: 15000,
    //     deposito: 5000,
    //   },
    //   {
    //     id: 2,
    //     nombreCliente: "Giudice Juan",
    //     dni: "23456789",
    //     fechaAlquiler: "2024-02-15",
    //     fechaDevolucion: "2024-02-20",
    //     precio: 7500,
    //     deposito: 2500,
    //   },
    //   {
    //     id: 3,
    //     nombreCliente: "Rodriguez Lucas",
    //     dni: "34567890",
    //     fechaAlquiler: "2024-03-10",
    //     fechaDevolucion: "2024-03-15",
    //     precio: 8000,
    //     deposito: 3000,
    //   },
    //   {
    //     id: 4,
    //     nombreCliente: "Pablo",
    //     dni: "45678901",
    //     fechaAlquiler: "2024-04-05",
    //     fechaDevolucion: "2024-04-10",
    //     precio: 25,
    //     deposito: 10,
    //   },
    //   {
    //     id: 5,
    //     nombreCliente: "Morales Evon",
    //     dni: "56789012",
    //     fechaAlquiler: "2024-05-01",
    //     fechaDevolucion: "2024-05-05",
    //     precio: 53,
    //     deposito: 20,
    //   },
    // ];

    // let modo = "";

    // function mostrarListaTransacciones(fechaInicio, fechaFin) {
    //   const lista = $("#listaTransacciones");
    //   lista.empty();
    //   let totalMonto = 0;

    //   alquileres.forEach((alquiler) => {
    //     const fechaReserva = new Date(alquiler.fechaAlquiler);
    //     const fechaDevolucion = new Date(alquiler.fechaDevolucion);
    //     const inicio = new Date(fechaInicio);
    //     const fin = new Date(fechaFin);

    //     if (
    //       (fechaReserva >= inicio && fechaReserva <= fin) ||
    //       (fechaDevolucion >= inicio && fechaDevolucion <= fin)
    //     ) {
    //       const monto =
    //         modo === "ingresos" ? alquiler.precio : alquiler.deposito;
    //       totalMonto += monto;

    //       lista.append(`
    //           <tr>
    //               <td>${alquiler.dni}</td>
    //               <td>${alquiler.fechaAlquiler}</td>
    //               <td>${alquiler.fechaDevolucion}</td>
    //               <td>${monto}</td>
    //           </tr>
    //         `);
    //     }
    //   });

    //   $("#totalMonto").text(`$${totalMonto}`);
    // }

    // function filtrarTransacciones() {
    //   const fechaInicio = $("#fechaInicio").val();
    //   const fechaFin = $("#fechaFin").val();

    //   if (fechaInicio && fechaFin) {
    //     mostrarListaTransacciones(fechaInicio, fechaFin);
    //   } else {
    //     alert("Por favor, selecciona ambas fechas.");
    //   }
    // }

    // $("#filtrarBtn").click(filtrarTransacciones);
  </script>
</body>

</html>