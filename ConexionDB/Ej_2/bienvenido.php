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
    $nombre = $_SESSION['username'];
    $sql_1 = "SELECT * FROM peliculasUsuario WHERE nombre='$nombre'";
    $result = $conn->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql_2 = "SELECT * FROM peliculasUsuario WHERE ISAN = '$isan'";
    $result_2 = $conn->query($sql_2);

    /** 
    if (empty($_POST["nombre"])) {
        $nombreErr = "El campo 'Nombre' no debe quedar vacío";
    } else {
        $nombre = $_POST["nombre"];
    }

    if (empty($_POST["ISAN"])) {
        $isanErr = "El campo 'ISAN' no debe quedar vacío";
    } else {
        $isan = $_POST["ISAN"];
    }

    if (empty($_POST["anio"])) {
        $anioErr = "El campo 'Año' no debe quedar vacío";
    } else {
        $anio = $_POST["anio"];
    }

    if (empty($_POST["puntuacion"])) {
        $valoracionErr = "El campo 'Puntuación' no debe quedar vacío";
    } else {
        $valoracion = $_POST["puntuacion"];
    } 

    if (empty($nombreErr) && empty($isanErr) && empty($anioErr) && empty($valoracionErr)) {
        
    } */

    if ($result_2->num_rows == 0 && $isan > 9999999) {

    } else {
        $sql_3 = "INSERT INTO peliculasUsuario VALUES ('$isan')";
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
