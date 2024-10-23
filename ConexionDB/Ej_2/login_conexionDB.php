<?php
session_start(); // Inicia la sesión

// Datos de conexión a la base de datos
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

// Obtiene el nombre de usuario y la contraseña del formulario de inicio de sesión
$login_name = $_POST['username'];
$login_password = $_POST['password'];

// Crea una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); // Termina el script si hay un error en la conexión
}

// Consulta SQL para verificar las credenciales del usuario
$sql = "SELECT nombre FROM users WHERE nombre = '$login_name' AND contrasena = '$login_password'";
$result = $conn->query($sql); // Ejecuta la consulta

// Verifica si se encontró un usuario con las credenciales proporcionadas
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc(); // Obtiene los datos del usuario
  $_SESSION['username'] = $row['nombre']; // Almacena el nombre de usuario en la sesión
  header('Location: bienvenido.php'); // Redirige al usuario a la página de bienvenida
} else {
  header('Location: login.php?error=1'); // Redirige a la página de inicio de sesión con un mensaje de error
}

// Cierra la conexión a la base de datos
$conn->close();
exit; // Termina el script
