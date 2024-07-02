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

$apellidos = isset($_POST["apellidos"]) ? filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING) : $errores[] = 'Apellidos no cargados.';
$nombres = isset($_POST["nombres"]) ? filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING) : $errores[] = 'Nombres no cargados.';
$numero_documento = isset($_POST["numero_documento"]) ? filter_input(INPUT_POST, 'numero_documento', FILTER_SANITIZE_STRING) : $errores[] = 'DNI no cargado.';
$telefono = isset($_POST["telefono"]) ? filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING) : $errores[] = 'Teléfono no cargado.';
$domicilio = isset($_POST["domicilio"]) ? filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_STRING) : $errores[] = 'Domicilio no cargado.';


if (!empty($errores)) {
    $retorno['estado'] = 2;
    $retorno['errores'] = $errores;
    echo json_encode($retorno);
    die();
}

$correo = isset($_POST['correo']) ? filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_STRING) : null;
$observacion = isset($_POST['correo']) ? filter_input(INPUT_POST, 'observacion', FILTER_SANITIZE_STRING) : null;

try {
    if ($_POST['accion'] == 'guardar') {
        $sqlCheck = "SELECT COUNT(*) FROM clientes WHERE numero_documento = :numero_documento AND activo = 1";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->execute([':numero_documento' => $numero_documento]);
        $exists = $stmtCheck->fetchColumn();

        if ($exists) {
            $retorno['estado'] = 0;
            $retorno['mensaje'] = "Ya existe un cliente con DNI " . $numero_documento;
            echo json_encode($retorno);
            die();
        } else {
            $sql = "INSERT INTO clientes (apellidos, nombres, numero_documento, telefono, domicilio, correo, observacion)
                    VALUES (:apellidos, :nombres, :numero_documento, :telefono, :domicilio, :correo, :observacion)";

            $param = [
                ":apellidos" => $apellidos,
                ":nombres" => $nombres,
                ":numero_documento" => $numero_documento,
                ":telefono" => $telefono,
                ":domicilio" => $domicilio,
                ":correo" => $correo,
                ":observacion" => $observacion
            ];

            $stmtInsert = $db->prepare($sql);
            $stmtInsert->execute($param);
            $retorno['estado'] = 1;
            echo json_encode($retorno);
        }
        die();
    } else if ($_POST['accion'] == 'editar') {
        $sql = "UPDATE clientes
                SET apellidos = :apellidos, nombres = :nombres, numero_documento = :numero_documento, telefono = :telefono, domicilio = :domicilio, correo = :correo, observacion = :observacion
                WHERE idCliente = :idCliente";

        $param = [
            ":apellidos" => $apellidos,
            ":nombres" => $nombres,
            ":numero_documento" => $numero_documento,
            ":telefono" => $telefono,
            ":domicilio" => $domicilio,
            ":correo" => $correo,
            ":observacion" => $observacion,
            ":idCliente" => $_POST['idCliente']
        ];

        $stmtInsert = $db->prepare($sql);
        $stmtInsert->execute($param);
        $retorno['estado'] = 1;
        echo json_encode($retorno);
        die();
    }
} catch (PDOException $err) {
    // echo "Ocurrio un error durante la operación." . $err->getMessage();
    $retorno['estado'] = 2;
    $retorno['errores'] = $err->getMessage();
    echo json_encode($retorno);
    die();
}
