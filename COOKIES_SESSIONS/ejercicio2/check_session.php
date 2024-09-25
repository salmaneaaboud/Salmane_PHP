<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar sesión</title>
</head>
<body>
    <h2>Verificar sesión</h2>

    <?php
    if (isset($_SESSION['username'])) {
        echo '<p>La sesión está activa. Usuario: ' . htmlspecialchars($_SESSION['username']) . '</p>';
    } else {
        echo '<p>No hay sesión activa.</p>';
    }
    ?>

    <a href="bienvenido.php">Regresar a la página de bienvenida</a>
</body>
</html>
