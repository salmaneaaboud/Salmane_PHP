<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
    <?php
        class Usuario {
            private $username;
            private $valoracion;
            private $comentario;

            function __construct($username, $valoracion, $comentario) {
                $this->username = $username;
                $this->valoracion = $valoracion;
                $this->comentario = $comentario;
            }

            function get_username() {
                return $this->username;
            }
            function get_valoracion() {
                return $this->valoracion;
            }
            function get_comentario() {
                return $this->comentario;
            }
        }
    ?>
    <h1>Dejar una Valoración y Comentario</h1>
    <form action="ejercicio5.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="valoracion">Valoración (1-5):</label>
        <select id="valoracion" name="valoracion" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br><br>

        <label for="comentario">Comentario:</label><br>
        <textarea id="comentario" name="comentario" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Enviar Comentario</button>
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = htmlspecialchars($_POST["usuario"]);
            $valoracion = htmlspecialchars($_POST["valoracion"]);
            $comentario = htmlspecialchars($_POST["comentario"]);

            $comentario_guardar = "Usuario: $usuario, Valoración: $valoracion, Comentario: $comentario\n";
            $usuario = new Usuario($usuario,$valoracion,$comentario);

            echo "<br>Comentario guardado.<br>";

            echo "<h2>Resultado de la encuesta del usuario ".$usuario->get_username()."</h2><br>";
            echo "Valoración: ".$usuario->get_valoracion()."<br>";
            echo "Comentario: ".$usuario->get_comentario();
        }
    ?>
</body>
</html>