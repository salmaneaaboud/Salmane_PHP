<?php
session_start(); // Inicia la sesión para poder acceder a las variables de sesión

session_destroy(); // Destruye todas las variables de sesión, cerrando la sesión del usuario

header('Location: login.php'); // Redirige al usuario a la página de inicio de sesión
exit; // Termina el script para evitar que se ejecute código adicional
