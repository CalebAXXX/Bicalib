<?php
session_start();
?>
<header>
    <div class="top-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="index.php">Iniciar sesión</a>
            <span> | </span>
            <a href="register.html">Crear cuenta</a>
        <?php endif; ?>
    </div>
    <div class="logo-container">
        <img src="images/logo-bicalib.png" alt="Logo BicaLib" width="120" />
        <h1>BicaLib</h1>
        <p>Tu Biblioteca Virtual</p>
    </div>
</header>
