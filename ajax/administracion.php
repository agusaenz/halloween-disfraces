<?php

require_once('../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8', $sql_usuario, $sql_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

if (isset($_POST['tipo'])) {
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
} else {
    echo "Ocurrio un error durante la operación.";
    die();
}

try {
    $sql = "SELECT c.numero_documento, a.fechaAlquiler, a.fechaDevolucion, a.formaDePago, a.$tipo
            FROM alquileres a
            JOIN clientes c ON c.idCliente = a.idCliente
            WHERE a.activo = 1 AND a.fechaAlquiler BETWEEN :fechaInicio AND :fechaFin
            ORDER BY a.fechaAlquiler ASC";
    $param = [
        ":fechaInicio" => $_POST['fechaInicio'],
        ":fechaFin" => $_POST['fechaFin']
    ];


    $stmt = $db->prepare($sql);
    $stmt->execute($param);

    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tabla = [];
    $total = 0;
    if (count($movimientos) > 0) {
        foreach ($movimientos as $movimiento) {
            $fechaAlq = DateTime::createFromFormat('Y-m-d', $movimiento['fechaAlquiler']);
            $fechaformatAlq = $fechaAlq->format('d / m / Y');
            $fechaDev = DateTime::createFromFormat('Y-m-d', $movimiento['fechaDevolucion']);
            $fechaformatDev = $fechaDev->format('d / m / Y');
            $total += $movimiento[$tipo];
            $precioFormat = number_format($movimiento[$tipo], 0, '', '.');

            $metodo;
            switch ($movimiento['formaDePago']) {
                case 1:
                    $metodo = "Efectivo";
                    break;
                case 1:
                    $metodo = "Crédito";
                    break;
                case 1:
                    $metodo = "Débito";
                    break;
                case 1:
                    $metodo = "Transferencia / QR";
                    break;
                default:
                    $metodo = " - ";
                    break;
            }

            $tabla[] = [
                $movimiento['numero_documento'],
                $fechaformatAlq,
                $fechaformatDev,
                $metodo,
                "$" . $precioFormat
            ];
        }
        $total = number_format($total, 0, '', '.');
        $data = ["data" => $tabla, "total" => $total];
        echo json_encode($data);
        die();
    } else {
        $data = ["data" => ["No hay clientes generados."]];
        return $data;
    }
} catch (PDOException $err) {
    echo "Ocurrio un error durante la operación." . $err->getMessage();
    die();
}
