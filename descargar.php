<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Acceso denegado.");
}

if (!isset($_GET['file'])) {
    die("Archivo no especificado.");
}

$archivo = basename($_GET['file']); // Evita rutas maliciosas
$ruta = realpath(__DIR__ . '/../pdfs/' . $archivo); // Ruta protegida fuera de htdocs

// Verifica que el archivo exista y esté dentro de la carpeta segura
if ($ruta && file_exists($ruta)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $archivo . '"');
    readfile($ruta);
    exit;
} else {
    die("Archivo no encontrado.");
}
?>
