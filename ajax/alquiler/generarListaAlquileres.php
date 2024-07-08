<?php

require_once('../../aut_config.inc.php');

try {
    $db = new PDO('mysql:host=' . $sql_host . ';dbname=' . $sql_db . ';charset=utf8', $sql_usuario, $sql_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fallo la conexión: " . $e->getMessage();
    die();
}

$dni = isset($_POST["filtroDNI"]) ? trim(filter_input(INPUT_POST, 'filtroDNI', FILTER_SANITIZE_NUMBER_INT)) : "";

try {
    $param = [];
    $whereClauses = [];

    if (isset($_POST['filtroDNI'])) {
        $whereClauses[] = "c.numero_documento = :dni";
        $param['dni'] = $_POST['filtroDNI'];
    }

    if (isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"])) {
        $whereClauses[] = "a.fechaAlquiler BETWEEN :fechaInicio AND :fechaFin";
        $param['fechaInicio'] = $_POST["fechaInicio"];
        $param['fechaFin'] = $_POST["fechaFin"];
    }

    $whereStr = "";
    if (!empty($whereClauses)) {
        $whereStr = " AND " . implode(" AND ", $whereClauses);
    }

    $sqlGet = "SELECT a.*, c.apellidos, c.nombres, c.numero_documento 
           FROM alquileres a
           LEFT JOIN clientes c ON a.idCliente = c.idCliente
           WHERE a.activo = 1" . $whereStr . "
           ORDER BY a.fechaAlquiler DESC";

    $stmt = $db->prepare($sqlGet);
    $stmt->execute($param);

    $alquileres = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (count($alquileres) > 0) {
        $tabla = [];
        foreach ($alquileres as $alquiler) {
            $fechaAlq = DateTime::createFromFormat('Y-m-d', $alquiler['fechaAlquiler']);
            $fechaformatAlq = $fechaAlq->format('d / m / Y');
            $fechaDev = DateTime::createFromFormat('Y-m-d', $alquiler['fechaDevolucion']);
            $fechaformatDev = $fechaDev->format('d / m / Y');

            $nombres = $alquiler['nombres'];
            $apellidos = $alquiler['apellidos'];
            $apenom = ($nombres && $apellidos) ? $apellidos . ", " . $nombres : '-';

            $dni = $alquiler['numero_documento'] ? $alquiler['numero_documento'] : '-';

            $acciones = "<a class='btn btn-primary verAlquilerBtn' href='carga-alquiler.php?idAlquiler={$alquiler['idAlquiler']}'>Ver / editar</a>
            <!--<button class='btn btn-success verAlquilerBtn'>Imprimir</button>-->
            <button class='btn btn-danger eliminarAlquilerBtn ml-2' onclick='borrarAlquiler(event, {$alquiler['idAlquiler']})'>Eliminar</button>";

            $tabla[] = [
                $apenom,
                $dni,
                $fechaformatAlq,
                $fechaformatDev,
                "$" . $alquiler['total'],
                "$" . $alquiler['deposito'],
                $acciones
            ];
        }
        $data = ["data" => $tabla];
    } else {
        $data = ["data" => [["No se encontraron alquileres.", "", "", "", "", "", ""]]];
    }
    echo json_encode($data);
    die();
} catch (PDOException $err) {
    echo "Ocurrio un error durante la operación." . $err->getMessage();
    die();
}
