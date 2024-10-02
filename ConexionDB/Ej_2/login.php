<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<p>
    <h2>Iniciar sesión</h2>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos. Inténtalo de nuevo.</p>";
    }
    ?>


    <form method="post" action="login_conexionDB.php">
        <label for="email">Usuario:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tienes cuenta? <a href="signup.php">Registrarse</a></p>
</body>
</html>
