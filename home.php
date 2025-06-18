<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Si no hay sesión, redirigir a la página de inicio
    header("Location: inicio.php");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>BicaLib - Biblioteca Virtual</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px 10px;
            position: relative;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .top-right form {
            display: inline;
        }

        .top-right button {
            color: white;
            background-color: #c62828;
            border: none;
            margin: 0 10px;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .top-right button:hover {
            background-color: #b71c1c;
        }

        .logo-container {
            margin-top: 40px;
        }

        .logo-container img {
            width: 120px;
            margin-bottom: 10px;
        }

        .logo-container h1 {
            margin: 10px 0 5px 0;
            font-size: 32px;
        }

        .logo-container p {
            margin: 0;
            font-size: 18px;
        }

        main {
            margin: 40px 20px;
        }

        .main-image {
            max-width: 90%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        p {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="top-right">
            <form action="logout.php" method="post">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>

        <div class="logo-container">
            <img src="images/logobicalip.png" alt="Logo BicaLib" />
            <h1>BicaLib</h1>
            <p>Tu Biblioteca Virtual</p>
        </div>
    </header>
    <main>
        <p>Bienvenido, <strong><?php echo htmlspecialchars($username); ?></strong> 👋</p>
        <p>¡Gracias por iniciar sesión! Aquí podrás explorar y descargar libros en formato PDF.</p>
        <!-- Aquí más adelante puedes poner los libros -->
    </main>
</body>
</html>
