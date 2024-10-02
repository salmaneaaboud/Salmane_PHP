<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <?php
        $username = $_POST["user"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $confirm_pwd = $_POST["confirm_pwd"];
        echo "Datos introducidos: <br>
        Usuario: $username<br>
        Email: $email<br>";
        if ($pwd != $confirm_pwd) {
            echo "No coinciden las contraseñas<br>";
        } else {
            echo "Coinciden las contraseñas<br>";
        }
    ?>
</body>
</html>