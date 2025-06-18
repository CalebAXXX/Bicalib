<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['subir'])) {
    $titulo = $_POST['titulo'];
    $usuario_id = $_SESSION['user_id'];
    $archivo = $_FILES['archivo'];

    if ($archivo['type'] != "application/pdf") {
        die("Solo se permiten archivos PDF.");
    }

    $nombre_archivo = time() . "_" . basename($archivo['name']);
    $ruta_destino = "uploads/" . $nombre_archivo;

    if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
        // Guardar en la base de datos
        $conn = new mysqli("localhost", "root", "", "login");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO libros (titulo, archivo, usuario_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titulo, $nombre_archivo, $usuario_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        echo "Libro subido correctamente. <a href='home.php'>Volver a inicio</a>";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
