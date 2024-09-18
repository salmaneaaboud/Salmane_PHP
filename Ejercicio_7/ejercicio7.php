<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
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
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
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
                $confirm_pwdError = "La contraseña es necesaria";
            } else {
                $confirm_pwd = $_POST["confirm_pwd"];
                if ($confirm_pwd != $pwd) {
                    $confirm_pwdError = "No coinciden las contraseñas.";
                }
            }
        }

        function ajustarEntrada($value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
        }
    ?>
    <h2>Formulario de registro con validación</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        Nombre: <input type="name" id="nombre" name="nombre">
        <span class="error">* <?php echo $nombreError;?></span>
        <br><br>
        Correo electrónico: <input type="name" id="email" name="email">
        <span class="error">* <?php echo $emailError;?></span>
        <br><br>
        Contraseña: <input type="password" id="pwd" name="pwd">
        <span class="error">* <?php echo $pwdError;?></span>
        <br><br>
        Confirmar Contraseña: <input type="password" id="confirm_pwd" name="pwd">
        <span class="error">* <?php echo $confirm_pwdError;?></span>
        <br><br>
        <input type="submit" id="button" value="Enviar">
    </form>

    <?php
        echo "<h2>Datos:</h2>";
        echo $nombre;
        echo "<br>";
        echo $email;
    ?>

</body>
</html>