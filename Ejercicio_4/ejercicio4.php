<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $apellido = htmlspecialchars($_POST["apellido"]);
    $email = htmlspecialchars($_POST["email"]);
    $telefono = htmlspecialchars($_POST["telefono"]);

    $contacto = "$nombre, $apellido, $email, $telefono\n";

    $archivo = 'agenda.txt';
    file_put_contents($archivo, $contacto, FILE_APPEND);

    echo "Contacto agregado exitosamente.";
}
