<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// REGISTRO
if (isset($_POST['register'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

    if ($password !== $password_confirm) {
        die("Las contraseñas no coinciden.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $verification_code = rand(100000, 999999);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, verification_code, is_verified) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("sssi", $username, $email, $hashed_password, $verification_code);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'adancaleb890@gmail.com';
            $mail->Password = 'doooqsjmcqueazhp'; // Contraseña de app
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('adancaleb890@gmail.com', 'Mi Biblioteca');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Código de verificación';
            $mail->Body = "Hola $username,<br>Tu código de verificación es: <b>$verification_code</b>";

            $mail->send();

            $_SESSION['email'] = $email;
            header("Location: verify.php");
            exit();
        } catch (Exception $e) {
            echo "Error al enviar correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}

// LOGIN
if (isset($_POST['login'])) {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        die("Faltan datos de inicio de sesión.");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "Usuario no encontrado.";
    } else {
        $stmt->bind_result($id, $username, $hashed_password, $is_verified);
        $stmt->fetch();

        if (!password_verify($password, $hashed_password)) {
            echo "Contraseña incorrecta.";
        } elseif ($is_verified != 1) {
            echo "Debes verificar tu correo antes de iniciar sesión.";
        } else {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: home.php"); // Redirige a la página de inicio
            exit();
        }
    }

    $stmt->close();
}

$conn->close();
?>




