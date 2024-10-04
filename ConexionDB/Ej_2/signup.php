<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
    <style>
        .error { color: #FF0000; }
    </style>
</head>
<body>
    <?php
        $nombreError = $emailError = $pwdError = $confirm_pwdError = "";
        $nombre = $email = $pwd = $confirm_pwd = "";
        $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{6,}$/";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["nombre"])) {
                $nombreError = "El nombre es necesario";
            } else {
                $nombre = ajustarEntrada($_POST["nombre"]);
                if (!preg_match("/^[a-zA-Z-'\s]+$/", $nombre)) {
                    $nombreError = "Sólo se permiten letras y espacios";
                }
            }

            if (empty($_POST["email"])) {
                $emailError = "El email es necesario";
            } else {
                $email = ajustarEntrada($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Error al introducir el email";
                }
            }

            if (empty($_POST["pwd"])) {
                $pwdError = "La contraseña es necesaria";
            } else {
                $pwd = ajustarEntrada($_POST["pwd"]);
                if (!preg_match($patron, $pwd)) {
                    $pwdError = "La contraseña no cumple con los requisitos";
                }
            }

            if (empty($_POST["confirm_pwd"])) {
                $confirm_pwdError = "La confirmación es necesaria";
            } else {
                $confirm_pwd = ajustarEntrada($_POST["confirm_pwd"]);
                if ($confirm_pwd != $pwd) {
                    $confirm_pwdError = "No coinciden las contraseñas.";
                }
            }

            if (empty($nombreError) && empty($emailError) && empty($pwdError) && empty($confirm_pwdError)) {
                $servername = "db";
                $username = "root";
                $password = "root";
                $dbname = "mydatabase";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users WHERE email='$email'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $emailError = "Ya existe una cuenta con este correo electrónico.";
                } else {
                    $sql = "INSERT INTO users (nombre, email, contrasena) VALUES ('$nombre', '$email', '$pwd')";
                    if ($conn->query($sql) === TRUE) {
                        header('Location: bienvenido.php');
                        exit();
                    } else {
                        echo "<p style='color:red;'>Error al registrar el usuario: " . $conn->error . "</p>";
                    }
                }

                $conn->close();
            }
        }

        function ajustarEntrada($value) {
            return htmlspecialchars(stripslashes(trim($value)));
        }
    ?>

    <h2>Formulario de registro con validación</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>">
        <span class="error">* <?php echo $nombreError;?></span>
        <br><br>
        
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailError;?></span>
        <br><br>
        
        <label for="pwd">Contraseña:</label>
        <input type="password" id="pwd" name="pwd">
        <span class="error">* <?php echo $pwdError;?></span>
        <br><br>
        
        <label for="confirm_pwd">Confirmar Contraseña:</label>
        <input type="password" id="confirm_pwd" name="confirm_pwd">
        <span class="error">* <?php echo $confirm_pwdError;?></span>
        <br><br>

        <input type="submit" id="button" value="Enviar">
    </form>
    <p>¿Tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
</body>
</html>
