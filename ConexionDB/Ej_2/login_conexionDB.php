<?php
session_start();

$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

$login_email = $_POST['email'];
$login_password = $_POST['password'];


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT nombre FROM users WHERE email = '$login_email' AND contrasena = '$login_password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $_SESSION['username'] = $row['nombre'];
  header('Location: bienvenido.php');
} else {
  header('Location: login.php?error=1');
}


$conn->close();
exit;