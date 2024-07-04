<?php

require_once('../../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8', $sql_usuario, $sql_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

$retorno = [];

if (isset($_POST['idAlquiler'])) {
    $idAlquiler = filter_input(INPUT_POST, 'idAlquiler', FILTER_SANITIZE_NUMBER_INT);
} else $errores[] = "Error, novedad no cargada.";

// if (count($errores) > 0) {
//     $retorno['estado'] = 2;
//     $retorno['errores'] = $errores[0];
//     print_r(json_encode($retorno));
//     die();
// }

try {
    $sql = "SELECT a.*, c.apellidos, c.nombres, c.numero_documento, c.telefono, c.domicilio, c.correo
            FROM alquileres a
            LEFT JOIN clientes c ON a.idCliente = c.idCliente
            WHERE a.activo = 1 AND a.idAlquiler = :idAlquiler";


    $stmt = $db->prepare($sql);
    $stmt->bindParam(":idAlquiler", $idAlquiler);
    $stmt->execute();

    $alquiler = $stmt->fetch(PDO::FETCH_ASSOC);

    $fechaAlq = DateTime::createFromFormat('Y-m-d', $alquiler['fechaAlquiler']);
    $fechaformatAlq = $fechaAlq->format('d/m/Y');
    $fechaDev = DateTime::createFromFormat('Y-m-d', $alquiler['fechaDevolucion']);
    $fechaformatDev = $fechaDev->format('d/m/Y');

    $alquiler['fechaAlquiler'] = $fechaformatAlq;
    $alquiler['fechaDevolucion'] = $fechaformatDev;

    $retorno['alquiler'] = $alquiler;
    $retorno['estado'] = 1;
    echo json_encode($retorno);
    die();
} catch (PDOException $err) {
    echo "Ocurrio un error durante la operación." . $err->getMessage();
    die();
}
