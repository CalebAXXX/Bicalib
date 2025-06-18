<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT titulo, archivo FROM libros ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros disponibles - BicaLib</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            position: relative;
            text-align: center;
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
            background-color: #388e3c;
            color: white;
            border: none;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .top-right button:hover {
            background-color: #2e7d32;
        }

        main {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            color: #4CAF50;
        }

        .libro {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .libro span {
            font-size: 18px;
        }

        .libro a {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .libro a:hover {
            background-color: #388e3c;
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
        <h1>BicaLib - Libros disponibles</h1>
    </header>
    <main>
        <h2>Lista de libros</h2>

        <?php while ($libro = $result->fetch_assoc()): ?>
            <div class="libro">
                <span><?php echo htmlspecialchars($libro['titulo']); ?></span>
                <a href="descargar.php?file=<?php echo urlencode($libro['archivo']); ?>">Descargar</a>
            </div>
        <?php endwhile; ?>

    </main>
</body>
</html>
