<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    // Si no está autenticado, redirige a la página de inicio de sesión
    header('Location: login.php');
    exit;
}

// VARIABLES
$nombre = $isan = $anio = $valoracion = $isan_borrar = ''; // Variables para almacenar datos de la película
$mensajeError = $mensajeErrorBorrar = ''; // Variables para mensajes de error
$mensajeExito = $mensajeExitoBorrar = ''; // Variables para mensajes de éxito

// VARIABLES_DB
$servername = "db"; // Nombre del servidor de base de datos
$username = "root"; // Usuario de la base de datos
$password = "root"; // Contraseña de la base de datos
$dbname = "mydatabase"; // Nombre de la base de datos

// Crea una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Termina el script si hay un error de conexión
}

// Verifica si el método de solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejo de la acción de agregar una película
    if (isset($_POST['agregar'])) {
        // Obtiene los datos del formulario
        $nombre = $_POST['nombre'];
        $isan = $_POST['ISAN'];
        $anio = date("Y", strtotime($_POST['anio'])); // Convierte la fecha a año
        $valoracion = $_POST['puntuacion'];

        $nombreUsuario = $_SESSION['username']; // Obtiene el nombre del usuario desde la sesión

        // Validaciones de los campos
        if (empty($nombre)) {
            $mensajeError = "El nombre es obligatorio";
        }

        if (empty($isan) || strlen($isan) !== 8) {
            $mensajeError .= "<br>El campo ISAN es obligatorio y debe tener exactamente 8 dígitos.";
        }

        if (empty($anio)) {
            $mensajeError .= "<br>El campo Año es obligatorio.";
        }

        if (empty($valoracion)) {
            $mensajeError .= "<br>El campo Puntuación es obligatorio.";
        }

        // Si no hay errores en la validación
        if (empty($mensajeError)) {
            // Verifica si el ISAN ya existe en la base de datos
            $sql_select_isan = "SELECT * FROM peliculasUsuario WHERE ISAN = '$isan'";
            $result_select = $conn->query($sql_select_isan);

            // Si el ISAN no existe, inserta una nueva película
            if ($result_select->num_rows == 0) {
                $sql_insert = "INSERT INTO peliculasUsuario (nombre, ISAN, nombre_pelicula, puntuacion, ano) VALUES ('$nombreUsuario', '$isan', '$nombre', '$valoracion', '$anio')";
                if ($conn->query($sql_insert) === TRUE) {
                    $mensajeExito = "Película insertada correctamente";
                } else {
                    echo "Error: " . $sql_insert . "<br>" . $conn->error; // Muestra el error en caso de fallo
                }
            } else {
                // Si el ISAN existe, actualiza la información de la película
                $sql_update = "UPDATE peliculasUsuario SET puntuacion = '$valoracion', ano = '$anio' WHERE ISAN = '$isan'";
                if ($conn->query($sql_update) === TRUE) {
                    $mensajeExito = "Película actualizada correctamente";
                } else {
                    echo "Error: " . $sql_update . "<br>" . $conn->error; // Muestra el error en caso de fallo
                }
            }
        }
    }
    // Manejo de la acción de borrar una película
    elseif (isset($_POST['borrar'])) {
        $isan_borrar = $_POST['ISAN_borrar']; // Obtiene el ISAN de la película a borrar
        // Validación del campo ISAN
        if (empty($isan_borrar)) {
            $mensajeErrorBorrar = 'El campo ISAN es obligatorio y debe tener exactamente 8 dígitos.';
        } else {
            // Ejecuta la consulta para borrar la película
            $sql_borrar = "DELETE FROM peliculasUsuario WHERE ISAN = '$isan_borrar'"; 
            if ($conn->query($sql_borrar) === TRUE) {
                $mensajeExitoBorrar = "Película eliminada correctamente";
            } else {
                echo "Error: " . $sql_borrar . "<br>" . $conn->error; // Muestra el error en caso de fallo
            }
        }
    }
}

// Consulta las películas del usuario logueado
if (isset($_SESSION['username'])) {
    $nombreUsuario = $_SESSION['username']; // Obtiene el nombre de usuario de la sesión
    $sql_nombre = "SELECT * FROM peliculasUsuario WHERE nombre='$nombreUsuario'"; // Consulta para obtener las películas
    $result = $conn->query($sql_nombre);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        .error { color: #FF0000; } // Estilo para mensajes de error
        .success { color: green; } // Estilo para mensajes de éxito
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2> <!-- Muestra el nombre del usuario -->
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
                // Muestra las películas si hay resultados
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
        <!-- Muestra mensajes de error o éxito -->
        <?php if (!empty($mensajeError)) echo "<div class='error'>$mensajeError</div>"; ?>
        <?php if (!empty($mensajeExito)) echo "<div class='success'>$mensajeExito</div>"; ?>
        <!-- Formulario para agregar una película -->
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
                    <td><input type="date" name="anio" id="anio" value="<?php echo htmlspecialchars($anio); ?>"></td>
                </tr>
                <tr>
                    <td><label for="puntuacion">Puntuación: </label></td>
                    <td><input type="number" min="0" max="5" name="puntuacion" id="puntuacion" value="<?php echo htmlspecialchars($valoracion); ?>"></td>
                </tr>
            </table>
            <input type="submit" name="agregar" value="Agregar película"> <!-- Botón para enviar el formulario -->
        </form>
        <h3>Borrar película</h3>
        <!-- Muestra mensajes de error o éxito -->
        <?php if (!empty($mensajeErrorBorrar)) echo "<div class='error'>$mensajeErrorBorrar</div>"; ?>
        <?php if (!empty($mensajeExitoBorrar)) echo "<div class='success'>$mensajeExitoBorrar</div>"; ?>
        <!-- Formulario para borrar una película -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr>
                    <td><label for="ISAN_borrar">ISAN: </label></td>
                    <td><input type="text" name="ISAN_borrar" id="ISAN_borrar" value="<?php echo htmlspecialchars($isan_borrar); ?>"></td>
                </tr>
            </table>
            <input type="submit" name="borrar" value="Borrar película"> <!-- Botón para enviar el formulario -->
        </form> 
    </div>
    <br><br>
    <a href="logout.php">Cerrar sesión</a> <!-- Enlace para cerrar sesión -->
</body>
</html>
