<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Manejo de subida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir'])) {
    $titulo = $_POST['titulo'];
    $archivo_nombre = $_FILES['archivo']['name'];
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $usuario_id = $_SESSION['user_id'];

    $carpeta_destino = 'pdfs/';
    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    $ruta_destino = $carpeta_destino . basename($archivo_nombre);

    if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
        $conn = new mysqli("localhost", "root", "", "login");
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO libros (titulo, archivo, usuario_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titulo, $archivo_nombre, $usuario_id);

        if ($stmt->execute()) {
            $mensaje = "¡Libro subido exitosamente!";
        } else {
            $mensaje = "Error al guardar en base de datos.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $mensaje = "Error al subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Subir libro - BicaLib</title>
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

        .top-right form button {
            color: white;
            background-color: #388e3c;
            border: none;
            margin: 0 10px;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .top-right form button:hover {
            background-color: #2e7d32;
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

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: left;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #388e3c;
        }

        .mensaje {
            margin-top: 20px;
            font-weight: bold;
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
        <h2>Subir un nuevo libro</h2>
        <form action="subir_libro.php" method="POST" enctype="multipart/form-data">
            <label for="titulo">Título del libro:</label>
            <input type="text" name="titulo" required>

            <label for="archivo">Selecciona el archivo PDF:</label>
            <input type="file" name="archivo" accept=".pdf" required>

            <button type="submit" name="subir">Subir libro</button>
        </form>

        <?php if (isset($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>

