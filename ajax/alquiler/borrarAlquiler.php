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

$idAlquiler = isset($_POST["idAlquiler"]) ? filter_input(INPUT_POST, 'idAlquiler', FILTER_SANITIZE_STRING) : $errores[] = 'error';

if (!empty($errores)) {
    $retorno['estado'] = 2;
    $retorno['errores'] = $errores;
    echo json_encode($retorno);
    die();
}

try {
    $sql = "UPDATE alquileres
            SET activo = 0
            WHERE idAlquiler = :idAlquiler AND activo = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":idAlquiler", $idAlquiler);
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
