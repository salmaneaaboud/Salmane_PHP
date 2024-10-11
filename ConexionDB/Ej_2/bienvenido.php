<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// VARIABLES_ERRORES
$nombreErr = $isanErr = $anioErr = $valoracionErr = '';

// VARIABLES
$nombre = $isan = $anio = $valoracion = '';

// VARIABLES_DB
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $nombreUsuario = $_SESSION['username'];
    $sql_nombre = "SELECT * FROM peliculasUsuario WHERE nombre='$nombreUsuario'";
    $result = $conn->query($sql_nombre);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : '';
    $isan = !empty($_POST['ISAN']) ? $_POST['ISAN'] : '';
    $anio = !empty($_POST['anio']) ? $_POST['anio'] : '';
    $valoracion = !empty($_POST['puntuacion']) ? $_POST['puntuacion'] : '';

    $nombreUsuario = $_SESSION['username'];

    if (empty($isan)) {
        echo "El campo ISAN es obligatorio.";
        return;
    }

    if (!empty($nombre) && !empty($anio) && !empty($valoracion)) {
        $sql_select_isan = "SELECT * FROM peliculasUsuario WHERE ISAN = '$isan'";
        $result_select = $conn->query($sql_select_isan);

        if ($result_select->num_rows == 0) {
            insertarPelicula($conn, $nombreUsuario, $isan, $nombre, $valoracion, $anio);
        } else {
            actualizarPelicula($conn, $valoracion, $anio, $isan);
        }
    } elseif (empty($nombre) && !empty($isan)) {
        eliminarPelicula($conn, $nombreUsuario, $isan);
    }
}

function insertarPelicula($conn, $nombreUsuario, $isan, $nombre, $valoracion, $anio) {
    if ($isan > 9999999) {
        $sql_insert = "INSERT INTO peliculasUsuario (nombre, ISAN, nombre_pelicula, puntuacion, ano) VALUES ('$nombreUsuario', '$isan', '$nombre', '$valoracion', '$anio')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Película insertada correctamente";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        echo "El ISAN debe tener 8 dígitos.";
    }
}

function actualizarPelicula($conn, $valoracion, $anio, $isan) {
    $sql_update = "UPDATE peliculasUsuario SET puntuacion = '$valoracion', ano = '$anio' WHERE ISAN = '$isan'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Película actualizada correctamente";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

function eliminarPelicula($conn, $nombreUsuario, $isan) {
    $sql_delete = "DELETE FROM peliculasUsuario WHERE ISAN = '$isan' AND nombre = '$nombreUsuario'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Se ha borrado la película";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        .error { color: #FF0000; }
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <h3>Mi lista de películas</h3>
    <div id="lista_peliculas">
        <table border="1">
            <tr>
                <th>ISAN</th>
                <th>Nombre</th>
                <th>Puntuación</th>
                <th>Año</th>
            </tr>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { 
                        echo "<tr>
                        <td>".$row['ISAN']."</td>
                        <td>".$row['nombre_pelicula']."</td>
                        <td>".$row['puntuacion']."</td>
                        <td>".$row['ano']."</td>
                        </tr>";
                    }
                }
            ?>
        </table>
    </div>
    <br>
    <div id="agregar_pelicula">
        <h3>Agregar película</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr>
                    <td><label for="nombre">Nombre: </label></td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                    <span class="error">* <?php echo $nombreErr; ?></span></td>
                </tr>
                <tr>
                    <td><label for="ISAN">ISAN: </label></td>
                    <td><input type="text" name="ISAN" id="ISAN" value="<?php echo htmlspecialchars($isan); ?>">
                    <span class="error">* <?php echo $isanErr; ?></span></td>
                </tr>
                <tr>
                    <td><label for="anio">Año: </label></td>
                    <td><input type="text" name="anio" id="anio" value="<?php echo htmlspecialchars($anio); ?>">
                    <span class="error">* <?php echo $anioErr; ?></span></td>
                </tr>
                <tr>
                    <td><label for="puntuacion">Puntuación: </label></td>
                    <td><input type="number" min="0" max="5" name="puntuacion" id="puntuacion" value="<?php echo htmlspecialchars($valoracion); ?>">
                    <span class="error">* <?php echo $valoracionErr; ?></span></td>
                </tr>
            </table>
            <input type="submit" value="Agregar película">
        </form>
    </div>
    <br><br>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
