<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
        Usuario: <input type="text" id="user" name="user"><br>
        Email: <input type="text" id="email" name="email"><br>
        Contraseña: <input type="password" id="pwd" name="pwd"><br>
        Confirmar contraseña: <input type="password" id="confirm_pwd" name="confirm_pwd"><br>
        <input type="submit" value="Enviar"><br>
    </form>
    <?php
        class Usuario {
            private $username;
            private $email;
            private $password;
            function __construct($username, $email, $password) {
                $this->username = $username;
                $this->email = $email;
                $this->password = $password;
            }
            function get_name() {
                return $this->username;
            }
            function get_email() {
                return $this->email;
            }
        }
        $username = $_POST["user"];
        $email = $_POST["email"];
        $password = $_POST["pwd"];
        $confirm_password = $_POST["confirm_pwd"];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($password !== $confirm_password) {
                echo "No coinciden las contraseñas<br>";
            } else if (!isset($password) || !isset($confirm_password)) {
                echo "Error. El campo de contraseña no debe estar vacío <br>";
            } else {
                echo "Coinciden las contraseñas<br>";
                $usuario = new Usuario($username,$email,$password);
                echo "Datos introducidos: <br>
                Usuario: ".$usuario->get_name()."<br>
                Email: ".$usuario->get_email()."<br>";
            }
        }
        
    ?>
</body>
</html>