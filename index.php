<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Iniciar sesión</h2>
    <form action="server.php" method="POST">
      <label for="email">Correo electrónico:</label><br>
      <input type="email" name="email" required><br><br>

      <label for="password">Contraseña:</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit" name="login">Iniciar sesión</button>
    </form>
    <p>¿No tienes cuenta? <a href="register.html">Regístrate aquí</a></p>
  </div>
</body>
</html>
