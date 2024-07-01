<?php

require_once('../../aut_config.inc.php');

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

        $sqlGet = " SELECT a.*, c.apellidos, c.nombres, c.numero_documento FROM alquileres a
                    JOIN clientes c ON a.idCliente = c.idCliente
                    WHERE a.activo = 1 AND c.numero_documento = :dni
                    ORDER BY a.fechaAlquiler DESC";
        $param['dni'] = $dni;
    } else {
        $sqlGet = " SELECT a.*, c.apellidos, c.nombres, c.numero_documento FROM alquileres a
                    JOIN clientes c ON a.idCliente = c.idCliente
                    WHERE a.activo = 1
                    ORDER BY a.fechaAlquiler DESC";
    }

    $stmt = $db->prepare($sqlGet);
    $stmt->execute($param);

    $alquileres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tabla = [];
    if (count($alquileres) > 0) {
        foreach ($alquileres as $alquiler) {
            $fechaAlq = DateTime::createFromFormat('Y-m-d', $alquiler['fechaAlquiler']);
            $fechaformatAlq = $fechaAlq->format('d / m / Y');
            $fechaDev = DateTime::createFromFormat('Y-m-d', $alquiler['fechaDevolucion']);
            $fechaformatDev = $fechaDev->format('d / m / Y');
            $acciones = "<button class='btn btn-primary verAlquilerBtn'>Ver / editar</button>
            <button class='btn btn-success verAlquilerBtn'>Imprimir</button>
                         <button class='btn btn-danger eliminarAlquilerBtn ml-2' onclick='borrarAlquiler(event, {$alquiler['idAlquiler']})'>Eliminar</button>
                         ";
                        

            $tabla[] = [
                $alquiler['apellidos'] . ' ' . $alquiler['nombres'],
                $alquiler['numero_documento'],
                $fechaformatAlq,
                $fechaformatDev,
                "$" . $alquiler['total'],
                "$" . $alquiler['deposito'],
                $acciones
            ];
        }
        $data = ["data" => $tabla];
        echo json_encode($data);
        die();
    } else {
        $data = ["data" => ["No hay clientes generados."]];
        return $data;
    }
} catch (PDOException $err) {
    echo "Ocurrio un error durante la operación." . $err->getMessage();
    die();
}
