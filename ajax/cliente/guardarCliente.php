<?php

// incluyo variables de conexion
require_once ('../../aut_config.inc.php');

try {
    // Armo la conexión a la base de datos con PDO
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8mb4', $sql_usuario, $sql_pass);
    // Seteo atributos de la conexión
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

date_default_timezone_set("America/Argentina/Buenos_Aires"); // Defino huso horario
$fechaactual = new \Datetime(); // Guardo la fecha de hoy con una función propia de PHP
$retorno = array(); // Creo el arreglo que será retornado al front
$errores = array(); // Arreglo de errores para retornar

// recupero los datos mandados desde el front
// y los sanitizo para prevenir inyecciones sql
// precaucion irrelevante en este caso, pero buena practica
$apellidos = isset($_POST["apellidos"]) ? filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING) : $errores[] = 'Apellidos no cargados.';
$nombres = isset($_POST["nombres"]) ? filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING) : $errores[] = 'Nombres no cargados.';
$numeroDocumento = isset($_POST["numeroDocumento"]) ? filter_input(INPUT_POST, 'numeroDocumento', FILTER_SANITIZE_STRING) : $errores[] = 'DNI no cargado.';
$telefono = isset($_POST["telefono"]) ? filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING) : $errores[] = 'Teléfono no cargado.';
$domicilio = isset($_POST["domicilio"]) ? filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_STRING) : $errores[] = 'Domicilio no cargado.';
$correo = isset($_POST["correo"]) ? filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL) : $errores[] = 'Correo no cargado.';

if (!empty($errores)) {
    $retorno['estado'] = 2;
    $retorno['errores'] = $errores;
    echo json_encode($retorno);
    die();
}

// FALTA validaciones segun datos ingresados

try {
    // Armo la sentencia SQL
    $sqlInsert = "INSERT INTO cliente (apellidos, nombres, numeroDocumento, telefono, domicilio, correo, fechaalta)
                  VALUES (:apellidos, :nombres, :numeroDocumento, :telefono, :domicilio, :correo, :fechaalta)";
    
    // Armo un arreglo para bindear los values de la sentencia con mis variables creadas
    $param = array(
        ":apellidos" => $apellidos,
        ":nombres" => $nombres,
        ":numeroDocumento" => $numeroDocumento,
        ":telefono" => $telefono,
        ":domicilio" => $domicilio,
        ":correo" => $correo,
        ":fechaalta" => $fechaactual->format("Y-m-d H:i:s")
    );

    // Preparo la base de datos
    $stmtInsert = $db->prepare($sqlInsert);
    // Ejecuto la sentencia, pasándole los valores como parámetro
    $stmtInsert->execute($param);

    // Campo control llamado estado para verificar en el front
    $retorno['estado'] = 1;
    // Envío el retorno en formato JSON
    echo json_encode($retorno);
    die();
} catch (PDOException $err) {
    // Si falla, retorno estado 2
    $retorno['estado'] = 2;
    $retorno['err'] = $err->getMessage();
    $retorno['errores'] = array("Ocurrió un error durante la operación. Inténtelo nuevamente.");
    echo json_encode($retorno);
    die();
}
