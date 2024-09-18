<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>
    <?php
        $nombreError = $emailError = $pwdError = $confirm_pwdError = "";
        $nombre = $email = $pwd = $confirm_pwd = "";
        $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{6,}$/";

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["nombre"])) {
                $nombreError = "El nombre es necesario";
            } else {
                $nombre = ajustarEntrada($_POST["nombre"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/",$nombre)) {
                    $nombreError = "Sólo se permiten letras y espacios";
                }
            }

            if (empty($_POST["email"])) {
                $emailError = "El email es necesario";
            } else {
                $email = ajustarEntrada($_POST["email"]);
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Error al introducir el email";
                }
            }

            if (empty($_POST["pwd"])) {
                $pwdError = "La contraseña es necesaria";
            } else {
                $pwd = ajustarEntrada($_POST["pwd"]);
                if (!preg_match($patron,$pwd)) {
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

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nombreError) && empty($emailError) && empty($pwdError) && empty($confirm_pwdError)) {
            echo "<h2>Datos registrados:</h2>";
            echo "Nombre: $nombre<br>";
            echo "Email: $email<br>";
        }
    ?>

</body>
</html>
