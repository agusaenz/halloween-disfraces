<?php

require_once ('../../aut_config.inc.php');

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

$dni = isset($_POST["dni"]) ? filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING) : $errores[] = 'Ingrese un DNI para buscar.';

if (!empty($errores)) {
    $retorno['estado'] = 3;
    $retorno['errores'] = $errores;
    echo json_encode($retorno);
    die();
}

try {
    $sql = "SELECT apellidos, nombres, telefono, domicilio, correo
            FROM clientes
            WHERE numero_documento = :dni AND activo = 1
            LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":dni", $dni);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    if($cliente) {
        $retorno['cliente'] = $cliente;
        $retorno['estado'] = 1;
    } else {
        $retorno['estado'] = 2;
    }
    
    echo json_encode($retorno);
    die();
} catch (PDOException $err) {
    // echo "Ocurrio un error durante la operación." . $err->getMessage();
    $retorno['estado'] = 3;
    $retorno['errores'] = $err->getMessage();
    echo json_encode($retorno);
    die();
}
