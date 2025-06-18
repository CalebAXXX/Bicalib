<?php
// Incluir las librerías de PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Usar las clases necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Datos para enviar el correo
$to_email = 'destinatario@example.com';  // Aquí cambia al correo del usuario al que enviarás el código
$from_email = 'adancaleb890@gmail.com';  // Tu correo Gmail
$from_name = 'Biblioteca BiancaCaleb';    // Nombre que quieres que aparezca como remitente
$smtp_password = 'dooo qsjm cque azhp';  // Tu contraseña de aplicación de Gmail

// Generar código de verificación aleatorio
$verification_code = rand(100000, 999999);

try {
    $mail = new PHPMailer(true);
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $from_email;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom($from_email, $from_name);
    $mail->addAddress($to_email);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Código de verificación para tu cuenta';
    $mail->Body = "<p>Tu código de verificación es: <b>$verification_code</b></p>";
    $mail->AltBody = "Tu código de verificación es: $verification_code";

    $mail->send();
    echo "Código de verificación enviado correctamente al correo $to_email.";

    // Aquí puedes guardar el código en la sesión o base de datos para validar después
    session_start();
    $_SESSION['verification_code'] = $verification_code;

} catch (Exception $e) {
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}
?>


