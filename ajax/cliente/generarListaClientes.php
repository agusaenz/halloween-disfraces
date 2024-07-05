<?php

require_once ('../../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8', $sql_usuario, $sql_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

$dni = isset($_POST["filtroDNI"]) ? filter_input(INPUT_POST, 'filtroDNI', FILTER_SANITIZE_NUMBER_INT) : "";

try {
    $param = [];
    if (isset($_POST['filtroDNI'])) {
        $dni = trim($dni);

        $sqlGet = "SELECT * FROM clientes WHERE numero_documento = :dni AND activo = 1";
        $param['dni'] = $dni;
    } else {
        $sqlGet = " SELECT * FROM clientes WHERE activo = 1
                    ORDER BY apellidos";
    }

    $stmt = $db->prepare($sqlGet);
    $stmt->execute($param);

    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tabla = [];
    if (count($clientes) > 0) {
        foreach ($clientes as $cliente) {
            $acciones = "<button class='btn btn-primary edit-btn' onclick='clickEditar(event, {$cliente['idCliente']}, \"{$cliente['apellidos']}\", \"{$cliente['nombres']}\", \"{$cliente['numero_documento']}\", \"{$cliente['correo']}\", \"{$cliente['telefono']}\", \"{$cliente['domicilio']}\")'>Ver / Editar</button>
            <a class='btn btn-warning edit-btn' href='carga-alquiler.php?__numero_documento={$cliente['numero_documento']}'>Alquiler</a>
            <button class='btn btn-danger delete-btn' onclick='borrarCliente(event, {$cliente['idCliente']}, \"{$cliente['apellidos']}\", \"{$cliente['nombres']}\")'>Eliminar</button>";

            $tabla[] = [
                $cliente['apellidos'] . ' ' . $cliente['nombres'],
                $cliente['numero_documento'],
                $cliente['telefono'],
                $cliente['domicilio'],
                $acciones
            ];
        }
        $data = ["data" => $tabla];
    } else {
        $data = ["data" => [["No se encontraron clientes.", "", "", "", ""]]];
    }
    echo json_encode($data);
    die();
} catch (PDOException $err) {
    echo "Ocurrio un error durante la operación." . $err->getMessage();
    die();
}
