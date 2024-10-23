<?php session_start(); // Inicia la sesión ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title> <!-- Título de la página -->
</head>
<body>
    <h2>Iniciar sesión</h2> <!-- Título de la sección de inicio de sesión -->

    <?php
    // Verifica si hay un error de inicio de sesión
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        // Muestra un mensaje de error si las credenciales son incorrectas
        echo "<p style='color:red;'>Usuario o contraseña incorrectos. Inténtalo de nuevo.</p>";
    }
    ?>

    <!-- Formulario para el inicio de sesión -->
    <form method="post" action="login_conexionDB.php"> <!-- Acción del formulario apunta a la página de procesamiento -->
        <label for="username">Nombre de usuario:</label> <!-- Etiqueta para el campo de nombre de usuario -->
        <input type="text" id="username" name="username" required> <!-- Campo de entrada para el nombre de usuario -->
        <br><br>
        <label for="password">Contraseña:</label> <!-- Etiqueta para el campo de contraseña -->
        <input type="password" id="password" name="password" required> <!-- Campo de entrada para la contraseña -->
        <br><br>
        <button type="submit">Ingresar</button> <!-- Botón para enviar el formulario -->
    </form>
    <p>¿No tienes cuenta? <a href="signup.php">Registrarse</a></p> <!-- Enlace a la página de registro -->
</body>
</html>
