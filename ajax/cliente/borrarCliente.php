<?php

$message = "##################\n";
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

$idCliente = isset($_POST["idCliente"]) ? filter_input(INPUT_POST, 'idCliente', FILTER_SANITIZE_STRING) : $errores[] = 'error';

if (!empty($errores)) {
    $retorno['estado'] = 2;
    $retorno['errores'] = $errores;
    echo json_encode($retorno);
    die();
}

try {
    $sql = "UPDATE clientes
            SET activo = 0
            WHERE idCliente = :idCliente AND activo = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":idCliente", $idCliente);
    $stmt->execute();
    $retorno['estado'] = 1;
    echo json_encode($retorno);
} catch (PDOException $err) {
    // echo "Ocurrio un error durante la operación." . $err->getMessage();
    $retorno['estado'] = 2;
    $retorno['errores'] = $err->getMessage();
    echo json_encode($retorno);
    die();
}
