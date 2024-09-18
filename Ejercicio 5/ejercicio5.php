<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars($_POST["usuario"]);
    $valoracion = htmlspecialchars($_POST["valoracion"]);
    $comentario = htmlspecialchars($_POST["comentario"]);

    $comentario_guardar = "Usuario: $usuario, Valoración: $valoracion, Comentario: $comentario\n";

    $archivo = 'reviews.txt';
    file_put_contents($archivo, $comentario_guardar, FILE_APPEND);

    echo "Comentario guardado exitosamente.";
}
?>