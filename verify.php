<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    echo "No hay sesión activa. Por favor regístrate primero.";
    exit();
}

$email = $_SESSION['email'];
$error = '';

if (isset($_POST['verify'])) {
    $input_code = trim($_POST['code']);

    // Consulta código guardado
    $stmt = $conn->prepare("SELECT verification_code FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $saved_code = $row['verification_code'];

        if ((int)$input_code === (int)$saved_code) {
            $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            session_destroy();
            echo "¡Código correcto! Tu cuenta ha sido verificada. <a href='index.html'>Inicia sesión</a>";
            exit();
        } else {
            $error = "Código incorrecto, intenta de nuevo.";
        }
    } else {
        $error = "No se encontró usuario con ese correo.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Verificación de Código</title>
    <style>
        /* Estilos simples */
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 400px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; }
        input[type="text"] { width: 100%; padding: 10px; margin: 15px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; background: #005f99; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #004466; }
        .error { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Ingresa tu código de verificación</h2>
    <form method="POST" action="">
        <input type="text" name="code" placeholder="Código de verificación" required maxlength="6" />
        <button type="submit" name="verify">Verificar</button>
    </form>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
</div>
</body>
</html>


