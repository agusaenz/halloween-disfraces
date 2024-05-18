<?php

// incluyo variables de conexion
require_once ('aut_config.inc.php');

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

// // printeo
// foreach ($results as $row) {
//     echo "id: " . $row["id"] . "<br>";
//     echo "nombre: " . $row["nombre"] . "<br>";
//     echo "apellido: " . $row["apellido"] . "<br>";
//     echo "fechanac: " . $row["fechanac"] . "<br>";
// }

// cierro conexiones
$stmtTest->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo</title>

    <!-- librerias -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script defer src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Accordion Item #1
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                    plugin adds the appropriate classes that we use to style each element. These classes control the
                    overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of
                    this with custom CSS or overriding our default variables. It's also worth noting that just about any
                    HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Accordion Item #2
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the
                    collapse plugin adds the appropriate classes that we use to style each element. These classes
                    control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                    modify any of this with custom CSS or overriding our default variables. It's also worth noting that
                    just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit
                    overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                    collapse plugin adds the appropriate classes that we use to style each element. These classes
                    control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                    modify any of this with custom CSS or overriding our default variables. It's also worth noting that
                    just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit
                    overflow.
                </div>
            </div>
        </div>
    </div>
</body>

</html>