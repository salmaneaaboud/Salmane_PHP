<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// VARIABLES
$nombre = $isan = $anio = $valoracion = '';
$mensajeError = $mensajeErrorBorrar = '';

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
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $isan = $_POST['ISAN'];
        $anio = $_POST['anio'];
        $valoracion = $_POST['puntuacion'];

        $nombreUsuario = $_SESSION['username'];

        if (empty($isan) || strlen($isan) !== 8) {
            $mensajeError = "El campo ISAN es obligatorio y debe tener exactamente 8 dígitos.";
        }

        if (empty($anio)) {
            $mensajeError .= "<br>El campo Año es obligatorio.";
        }

        if (empty($valoracion)) {
            $mensajeError .= "<br>El campo Puntuación es obligatorio.";
        }

        if (empty($mensajeError)) {
            $sql_select_isan = "SELECT * FROM peliculasUsuario WHERE ISAN = '$isan'";
            $result_select = $conn->query($sql_select_isan);

            if ($result_select->num_rows == 0) {
                insertarPelicula($conn, $nombreUsuario, $isan, $nombre, $valoracion, $anio);
            } else {
                actualizarPelicula($conn, $valoracion, $anio, $isan);
            }
        }
    }
    elseif (isset($_POST['borrar'])) {
        $isan_borrar = $_POST['ISAN_borrar'];
        if (empty($isan_borrar)) {
            $mensajeErrorBorrar = 'El campo ISAN es obligatorio y debe tener exactamente 8 dígitos.';
        } else {
            borrarPelicula($conn, $isan_borrar);
        }
    }
    
}

function insertarPelicula($conn, $nombreUsuario, $isan, $nombre, $valoracion, $anio) {
    $sql_insert = "INSERT INTO peliculasUsuario (nombre, ISAN, nombre_pelicula, puntuacion, ano) VALUES ('$nombreUsuario', '$isan', '$nombre', '$valoracion', '$anio')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Película insertada correctamente";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
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

function borrarPelicula($conn, $isan) {
    $sql_borrar = "DELETE FROM peliculasUsuario WHERE isan = '$isan'"; 
    if ($conn->query($sql_borrar) === TRUE) {
        echo "Película eliminada correctamente";
    } else {
        echo "Error: " . $sql_borrar . "<br>" . $conn->error;
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
                        <td>".htmlspecialchars($row['ISAN'])."</td>
                        <td>".htmlspecialchars($row['nombre_pelicula'])."</td>
                        <td>".htmlspecialchars($row['puntuacion'])."</td>
                        <td>".htmlspecialchars($row['ano'])."</td>
                        </tr>";
                    }
                }
            ?>
        </table>
    </div>
    <br>
    <div id="agregar_pelicula">
        <h3>Agregar película</h3>
        <?php if (!empty($mensajeError)) echo "<div class='error'>$mensajeError</div>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr>
                    <td><label for="nombre">Nombre: </label></td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>"></td>
                </tr>
                <tr>
                    <td><label for="ISAN">ISAN: </label></td>
                    <td><input type="text" name="ISAN" id="ISAN" value="<?php echo htmlspecialchars($isan); ?>"></td>
                </tr>
                <tr>
                    <td><label for="anio">Año: </label></td>
                    <td><input type="text" name="anio" id="anio" value="<?php echo htmlspecialchars($anio); ?>"></td>
                </tr>
                <tr>
                    <td><label for="puntuacion">Puntuación: </label></td>
                    <td><input type="number" min="0" max="5" name="puntuacion" id="puntuacion" value="<?php echo htmlspecialchars($valoracion); ?>"></td>
                </tr>
            </table>
            <input type="submit" name="agregar" value="Agregar película">
        </form>
        <h3>Borrar película</h3>
        <?php if (!empty($mensajeErrorBorrar)) echo "<div class='error'>$mensajeErrorBorrar</div>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <table>
                    <tr>
                        <td><label for="ISAN_borrar">ISAN: </label></td>
                        <td><input type="text" name="ISAN_borrar" id="ISAN_borrar" value="<?php echo htmlspecialchars($isan); ?>"></td>
                    </tr>
                </table>
                <input type="submit" name="borrar" value="Borrar película">
        </form> 
    </div>
    <br><br>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
