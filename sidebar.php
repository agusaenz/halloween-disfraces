<?php
$sidebar = "
<div class='sidebar-footer'>
    <form class='search-bar search-bar-sd input-group' onsubmit='return searchClients();'>
      <input class='form-control' id='searchInput' type='search' placeholder='Buscar por DNI...' aria-label='Buscar'>
      <button class='btn btn-primary' type='button' onclick='searchClients()'>Buscar</button>
    </form>
    <button class='logout-button' onclick='logout()'>Cerrar sesión</button>
</div>

<div class='sidebar'>
    <a class='sidebar-brand' href='main.php'>
      <img src='assets/img/Halloween-Logo.png' alt='Logo de Halloween Disfraces'>
    </a>
    <ul class='sidebar-nav nav flex-column'>
      <li class='nav-item'>
        <a class='nav-link' href='lista-clientes.php'>
          <img src='assets/img/nueva-cuenta.png' alt='Clientes Icon'> Clientes
        </a>
      </li>
      <li class='nav-item'>
        <!--<a class='nav-link' href='#'><img src='assets/img/reserva.png' alt='Alquileres Icon'> Alquiler&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; </a>-->
        <ul class='dropdown-menu'>
          <li><a class='dropdown-item' href='lista-alquileres.php'><i class='bi bi-list'></i> Lista de alquileres</a></li>
          <li><a class='dropdown-item' href='carga-alquiler.php'><i class='bi bi-plus-circle'></i> Nuevo alquiler</a></li>
        </ul>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='administracion.php'>
          <img src='assets/img/administrar.png' alt='Administracion Icon'> Administracion
        </a>
      </li>
    </ul>
</div>
";
