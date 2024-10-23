<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
    <style>
        .error { color: #FF0000; } /* Estilo para los mensajes de error */
    </style>
</head>
<body>
    <?php
        // Inicializa las variables para los mensajes de error y los valores de entrada
        $nombreError = $emailError = $pwdError = $confirm_pwdError = "";
        $nombre = $email = $pwd = $confirm_pwd = "";
        // Patrón para validar la contraseña
        $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{6,}$/";

        // Verifica si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validación del nombre
            if (empty($_POST["nombre"])) {
                $nombreError = "El nombre es necesario"; // Mensaje de error si está vacío
            } else {
                $nombre = ajustarEntrada($_POST["nombre"]); // Limpia la entrada
                // Verifica que solo contenga letras y espacios
                if (!preg_match("/^[a-zA-Z-'\s]+$/", $nombre)) {
                    $nombreError = "Sólo se permiten letras y espacios";
                }
            }

            // Validación del correo electrónico
            if (empty($_POST["email"])) {
                $emailError = "El email es necesario"; // Mensaje de error si está vacío
            } else {
                $email = ajustarEntrada($_POST["email"]); // Limpia la entrada
                // Verifica que el correo electrónico tenga un formato válido
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Error al introducir el email";
                }
            }

            // Validación de la contraseña
            if (empty($_POST["pwd"])) {
                $pwdError = "La contraseña es necesaria"; // Mensaje de error si está vacío
            } else {
                $pwd = ajustarEntrada($_POST["pwd"]); // Limpia la entrada
                // Verifica que la contraseña cumpla con el patrón
                if (!preg_match($patron, $pwd)) {
                    $pwdError = "La contraseña no cumple con los requisitos";
                }
            }

            // Validación de la confirmación de la contraseña
            if (empty($_POST["confirm_pwd"])) {
                $confirm_pwdError = "La confirmación es necesaria"; // Mensaje de error si está vacío
            } else {
                $confirm_pwd = ajustarEntrada($_POST["confirm_pwd"]); // Limpia la entrada
                // Verifica que las contraseñas coincidan
                if ($confirm_pwd != $pwd) {
                    $confirm_pwdError = "No coinciden las contraseñas.";
                }
            }

            // Si no hay errores, procede a insertar el usuario en la base de datos
            if (empty($nombreError) && empty($emailError) && empty($pwdError) && empty($confirm_pwdError)) {
                // Datos de conexión a la base de datos
                $servername = "db";
                $username = "root";
                $password = "root";
                $dbname = "mydatabase";

                // Crea una conexión a la base de datos
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Verifica si la conexión fue exitosa
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error); // Termina el script si hay error
                }

                // Consulta para verificar si el correo o nombre ya existen
                $sql = "SELECT * FROM users WHERE email='$email' OR nombre='$nombre'";
                $result = $conn->query($sql); // Ejecuta la consulta
                if ($result->num_rows > 0) {
                    echo "Ya existe una cuenta con este correo electrónico o nombre."; // Mensaje si ya existe
                } else {
                    // Inserta el nuevo usuario en la base de datos
                    $sql = "INSERT INTO users (nombre, email, contrasena) VALUES ('$nombre', '$email', '$pwd')";
                    if ($conn->query($sql) === TRUE) {
                        header('Location: bienvenido.php'); // Redirige a la página de bienvenida
                        exit();
                    } else {
                        echo "<p style='color:red;'>Error al registrar el usuario: " . $conn->error . "</p>"; // Mensaje de error
                    }
                }

                $conn->close(); // Cierra la conexión a la base de datos
            }
        }

        // Función para limpiar la entrada de datos
        function ajustarEntrada($value) {
            return htmlspecialchars(stripslashes(trim($value))); // Limpia y ajusta la entrada
        }
    ?>

    <h2>Formulario de registro con validación</h2>
    <!-- Formulario para el registro de usuarios -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>">
        <span class="error">* <?php echo $nombreError;?></span> <!-- Mensaje de error para el nombre -->
        <br><br>
        
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailError;?></span> <!-- Mensaje de error para el correo -->
        <br><br>
        
        <label for="pwd">Contraseña:</label>
        <input type="password" id="pwd" name="pwd">
        <span class="error">* <?php echo $pwdError;?></span> <!-- Mensaje de error para la contraseña -->
        <br><br>
        
        <label for="confirm_pwd">Confirmar Contraseña:</label>
        <input type="password" id="confirm_pwd" name="confirm_pwd">
        <span class="error">* <?php echo $confirm_pwdError;?></span> <!-- Mensaje de error para la confirmación de la contraseña -->
        <br><br>

        <input type="submit" id="button" value="Enviar"> <!-- Botón de envío -->
    </form>
    <p>¿Tienes cuenta? <a href="login.php">Iniciar sesión</a></p> <!-- Enlace a la página de inicio de sesión -->
</body>
</html>
