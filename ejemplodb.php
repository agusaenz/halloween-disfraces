<?php

// incluyo variables de conexion
require_once ('dbconnect.inc.php');

// creo conexion
$db = new mysqli($servername, $username, $password, $dbname);

// checkeo conexion
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// defino query (es un string comun)
$sqlTest = "SELECT *
            FROM prueba";

// preparo db, checkeo y ejecuto
$stmtTest = $db->prepare($sqlTest);
if (!$stmtTest) {
    die("Preparation failed: " . $db->error);
}
$stmtTest->execute();

// guardo resultados en un arreglo
$result = $stmtTest->get_result();
$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

// printeo
foreach ($results as $row) {
    echo "id: " . $row["id"] . "<br>";
    echo "nombre: " . $row["nombre"] . "<br>";
    echo "apellido: " . $row["apellido"] . "<br>";
    echo "fechanac: " . $row["fechanac"] . "<br>";
}

// cierro conexiones
$stmtTest->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>hola</h1>
    <p>hola</p>
</body>
</html>
