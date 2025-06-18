<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = $_POST['codigo'];

    if (isset($_SESSION['verification_code'])) {
        if ($codigo_ingresado == $_SESSION['verification_code']) {
            // Código correcto: aquí puedes continuar con el registro o login
            echo "✅ Código correcto. Puedes continuar.";

            // Por seguridad, borrar el código de sesión para que no se use de nuevo
            unset($_SESSION['verification_code']);
            unset($_SESSION['email_to_verify']);

            // Aquí puedes redirigir o mostrar el formulario de registro por ejemplo
            // header("Location: register.html");
            // exit();
        } else {
            echo "❌ Código incorrecto. Intenta de nuevo.";
        }
    } else {
        echo "⚠️ No se encontró ningún código para validar. Vuelve a enviar el correo.";
    }
} else {
    echo "Método no permitido.";
}
?>
