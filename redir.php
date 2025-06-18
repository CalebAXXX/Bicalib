<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Usuario no ha iniciado sesión, lo enviamos a la página de invitado
    header("Location: inicio.html");
    exit();
} else {
    // Usuario ya está logueado, lo enviamos a la página principal
    header("Location: home.php");
    exit();
}
?>



