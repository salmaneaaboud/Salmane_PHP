<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

try {
  // Conexión a MySQL
  $connection = new mysqli($servername, $username, $password);
  
  // Crear la base de datos si no existe
  $createDB = "CREATE DATABASE IF NOT EXISTS $dbname";
  if ($connection->query($createDB) === FALSE) {
      echo "Error al crear la base de datos.<br>";
  }

  // Conectar a la base de datos recién creada
  $connection->select_db($dbname);

  // Crear la tabla 'users' si no existe
  $createTable1 = "CREATE TABLE IF NOT EXISTS users (
      nombre VARCHAR(30) NOT NULL,
      email VARCHAR(30) NOT NULL,
      contrasena VARCHAR(50) NOT NULL,
      primary key (nombre)
  )";
  if ($connection->query($createTable1) === FALSE) {
      echo "Error al crear la tabla Usuarios.<br>";
  }

  // Crear la tabla 'peliculasUsuario' si no existe
  $createTable2 = "CREATE TABLE IF NOT EXISTS peliculasUsuario (
      nombre VARCHAR(30) NOT NULL,
      ISAN int(11) NOT NULL,
      nombre_pelicula VARCHAR(120) NOT NULL,
      puntuacion int(5) NOT NULL,
      ano int(11) NOT NULL,
      primary key (ISAN),
      foreign key (nombre) references users(nombre)
  )";
  if ($connection->query($createTable2) === FALSE) {
      echo "Error al crear la tabla Usuarios.<br>";
  }
  
} catch (Exception $e) {
  die('Error: ' . $e->getMessage());
}

$connection->close();
