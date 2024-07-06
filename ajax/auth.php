<?php
session_start();

// timeout
$sessionTimeout = 3600;

// compara ultima actividad con timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionTimeout)) {
  // ultima actividad > timeout
  session_unset(); // unset vars de sesion
  session_destroy(); // destruye sesion
  header('Location: login.html'); // redirige a login
  exit;
}

// actualiza ultima actividad
$_SESSION['LAST_ACTIVITY'] = time();

// checkea si el usuario esta logeado
if (!isset($_SESSION['user_id'])) {
  // si no, redirige a login
  header('Location: login.html');
  exit;
}
