<?php

require_once('../../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8mb4', $sql_usuario, $sql_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

// date_default_timezone_set("America/Argentina/Buenos_Aires");
// $fechaactual = new \Datetime();
$retorno = [];
$errores = [];

$disfraz = isset($_POST["disfraz"]) ? filter_input(INPUT_POST, 'disfraz', FILTER_SANITIZE_STRING) : null;
$fechaAlq = isset($_POST["fechaAlq"]) ? filter_input(INPUT_POST, 'fechaAlq', FILTER_SANITIZE_STRING) : null;
$fechaDev = isset($_POST["fechaDev"]) ? filter_input(INPUT_POST, 'fechaDev', FILTER_SANITIZE_STRING) : null;
$total = isset($_POST["total"]) ? filter_input(INPUT_POST, 'total', FILTER_SANITIZE_STRING) : null;
$deposito = isset($_POST["deposito"]) ? filter_input(INPUT_POST, 'deposito', FILTER_SANITIZE_STRING) : null;
$formaPago = isset($_POST["formaPago"]) ? filter_input(INPUT_POST, 'formaPago', FILTER_SANITIZE_STRING) : null;
$detalle = isset($_POST["detalle"]) ? filter_input(INPUT_POST, 'detalle', FILTER_SANITIZE_STRING) : null;

switch ($formaPago) {
    case 'efectivo':
        $formaPago = 1;
        break;
    case 'debito':
        $formaPago = 3;
        break;
    case 'credito':
        $formaPago = 2;
        break;
    case 'transferencia':
        $formaPago = 4;
        break;
    default:
        $formaPago = 1;
        break;
}

// if (!empty($errores)) {
//     $retorno['estado'] = 2;
//     $retorno['errores'] = $errores;
//     echo json_encode($retorno);
//     die();
// }


try {
    $param = [];
    if (isset($_POST["dni"]) && $_POST["dni"] != null && $_POST["dni"] != '') {
        $dni = trim(filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT));
        $sqlFind = "SELECT idCliente FROM clientes WHERE numero_documento = :dni AND activo = 1";
        $stmtFind = $db->prepare($sqlFind);
        $stmtFind->execute([':dni' => $dni]);
        $resultado = $stmtFind->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $idCliente = $resultado['idCliente'];

            $sql = "INSERT INTO alquileres (idCliente, disfraces, detalle, total, deposito, formaDePago, fechaAlquiler, fechaDevolucion)
                    VALUES (:idCliente, :disfraz, :detalle, :total, :deposito, :formaPago, :fechaAlq, :fechaDev)";

            $param = [
                ":idCliente" => $idCliente,
                ":disfraz" => $disfraz,
                ":detalle" => $detalle,
                ":total" => $total,
                ":deposito" => $deposito,
                ":formaPago" => $formaPago,
                ":fechaAlq" => $fechaAlq,
                ":fechaDev" => $fechaDev
            ];
        } else {
            $retorno['estado'] = 2;
            $retorno['errores'] = "Ocurrio un error durante la operación.";
            echo json_encode($retorno);
            die();
        }
    } else {
        $sql = "INSERT INTO alquileres (disfraces, detalle, total, deposito, formaDePago, fechaAlquiler, fechaDevolucion)
                    VALUES (:disfraz, :detalle, :total, :deposito, :formaPago, :fechaAlq, :fechaDev)";

        $param = [
            ":disfraz" => $disfraz,
            ":detalle" => $detalle,
            ":total" => $total,
            ":deposito" => $deposito,
            ":formaPago" => $formaPago,
            ":fechaAlq" => $fechaAlq,
            ":fechaDev" => $fechaDev
        ];
    }
    $stmtInsert = $db->prepare($sql);
    $stmtInsert->execute($param);
    $retorno['estado'] = 1;
    echo json_encode($retorno);
    die();
} catch (PDOException $err) {
    // echo "Ocurrio un error durante la operación." . $err->getMessage();
    $retorno['estado'] = 2;
    $retorno['errores'] = $err->getMessage();
    echo json_encode($retorno);
    die();
}
