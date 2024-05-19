<?php

// incluyo variables de conexion
require_once ('../../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8mb4', $sql_usuario, $sql_pass);

    //seteo atributos de la conexion
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexion: ";
    die();
}

$fechaactual = new \Datetime();
$retorno = array();

if (isset($_POST["apellidos"]))
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
if (isset($_POST["nombres"]))
    $nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING);
if (isset($_POST["numeroDocumento"]))
    $numeroDocumento = filter_input(INPUT_POST, 'numeroDocumento', FILTER_SANITIZE_STRING);
if (isset($_POST["telefono"]))
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
if (isset($_POST["domicilio"]))
    $domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_STRING);
if (isset($_POST["correo"]))
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_STRING);

// $apellidos = $_POST["apellidos"];
// $nombres = $_POST["nombres"];
// $domicilio = $_POST["domicilio"];
// $numeroDocumento = $_POST["numeroDocumento"];
// $telefono = $_POST["telefono"];
// $correo = $_POST["correo"];

try {
    $sqlInsert = "  INSERT INTO cliente(apellidos, nombres, numeroDocumento, telefono, domicilio, correo, fechaalta)
                    VALUES (:apellidos, :nombres, :numeroDocumento, :telefono, :domicilio, :correo, :fechaalta)";

    $param = array(
        ":apellidos" => $apellidos,
        ":nombres" => $nombres,
        ":numeroDocumento" => $numeroDocumento,
        ":telefono" => $telefono,
        ":domicilio" => $domicilio,
        ":correo" => $correo,
        ":fechaalta" => $fechaactual->format("Y-m-d H:i:s")
    );

    $stmtInsert = $db->prepare($sqlInsert);
    $stmtInsert->execute($param);

    $retorno['estado'] = 1;
    print_r(json_encode($retorno));
    die();
} catch (PDOException $err) {
    $retorno['estado'] = 2;
    $retorno['errores'] = array("Ocurrio un error durante la operación. Intentelo nuevamente.");

    print_r(json_encode($retorno));
    die();
}