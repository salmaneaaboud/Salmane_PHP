<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = 'INSERT INTO users (nombre,apellidos,contrasena) values ';
if ($conn->query($sql) === TRUE) {
  echo "Usuario registrado";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
