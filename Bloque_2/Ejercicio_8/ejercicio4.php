<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
    <?php
        class Usuario {
            private $nombre;
            private $apellido;
            private $email;
            private $telefono;

            function __construct($nombre, $apellido, $email, $telefono) {
                $this->nombre = $nombre;
                $this->apellido = $apellido;
                $this->email = $email;
                $this->telefono = $telefono;
            }

            function get_nombre() {
                return $this->nombre;
            }
            function get_apellido() {
                return $this->apellido;
            }
            function get_email() {
                return $this->email;
            }
            function get_telefono() {
                return $this->telefono;
            }
        }
    ?>

    <h1>Agregar Contacto</h1>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br><br>

        <button type="submit">Agregar Contacto</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = htmlspecialchars($_POST["nombre"]);
            $apellido = htmlspecialchars($_POST["apellido"]);
            $email = htmlspecialchars($_POST["email"]);
            $telefono = htmlspecialchars($_POST["telefono"]);
        
            if (empty($nombre) || empty($apellido) || empty($email) || empty($telefono)) {
                echo "Todos los campos deben ser llenados.";
            } else {
                $usuario = new Usuario($nombre, $apellido, $email, $telefono);
                echo "<br>Usuario agregado. <br>";
                echo "Nombre: ".$usuario->get_nombre()." ".$usuario->get_apellido()." - Email: ".$usuario->get_email()." - Teléfono: ".$usuario->get_telefono()."<br>";
            }
        }

    ?>
</body>
</html>
