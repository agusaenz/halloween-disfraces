<?php
require_once('sidebar.php');
include 'ajax/auth.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halloween Disfraces</title>

  <!-- librerias -->
  <!-- bootstrap -->
  <link rel="stylesheet" href="assets/includes/css/bootstrap.min.css">
  <script defer src="assets/includes/js/bootstrap.bundle.min.js"></script>
  <!-- jquery -->
  <script src="assets/includes/js/jquery-3.7.1.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <script src="assets/js/sidebar.js"></script>


  <style>
    body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #b39b9b;
    font-family: 'Roboto', sans-serif;
    font-size: 0.9rem;
    margin: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    width: 100%;
}

.custom-card, .custom-card-2 {
    background: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    width: 20%;
    max-width: 200px; /* Set a fixed max-width */
    min-width: 200px; /* Set a fixed min-width */
    margin: 10px;
    text-align: center;
    position: relative;
    cursor: pointer;
}

.custom-card img, .custom-card-2 img {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
}

.custom-card a, .custom-card-2 a {
    color: black;
    text-decoration: none;
    font-weight: bold;
}

.custom-card p, .custom-card-2 p {
    color: gray;
    font-size: 0.8rem;
    margin: 5px 0 0;
}

.dropdown-content-main {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 0 0 10px 10px;
    overflow: hidden;
}

.dropdown-content a {
    text-decoration: none;
    color: black;
    display: block;
    padding: 10px;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.custom-card:hover .dropdown-content, .custom-card-2:hover .dropdown-content {
    display: block;
    animation: slideDown 0.3s ease-in-out;
}

.sidebar-container {
    width: 250px;
    flex-shrink: 0;
}

.content-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    overflow-y: auto;
    margin-top: 70px;
    height: 40vh;
}

@media (max-height: 700px) {
    .content-container {
        margin-top: 50px;
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10%);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

  </style>
</head>

<body>
  <div class="sidebar-container">
    <?php
    echo $sidebar;
    ?>
  </div>
  <div class="content-container">
    <div class="custom-card">
      <a href="lista-clientes.php">
        <img src="assets/img/nueva-cuenta2.png" alt="Icono 1">
        <span class="py-5 ">Clientes</span>
      </a>
    </div>
    <div class="custom-card-2">
      <img src="assets/img/reserva2.png" alt="Icono 3">
      <a href="#">Alquileres</a>
      <div class="dropdown-content dropdown-content-main">
        <a href="lista-alquileres.php">Lista de Alquileres</a>
        <a href="carga-alquiler.php">Nuevo Alquiler</a>
      </div>
    </div>
    <div class="custom-card">
      <a href="administracion.php" class="custom-card-link">
        <img src="assets/img/administrar2.png" alt="Icono 2">
        <span class="py-5">Administracion</span>
      </a>
    </div>


  </div>

  <script>
    document.querySelectorAll('.custom-card-2').forEach(card => {
      card.addEventListener('click', function() {
        this.querySelector('.dropdown-content-main').classList.toggle('show');
      });
    });

    adjustSidebarWidth(200)
  </script>

</body>

</html>