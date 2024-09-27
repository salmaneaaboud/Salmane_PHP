<?php
session_start();

$correct_username = 'admin';
$correct_password = '1234';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['username'] = $username;
        header('Location: bienvenido.php');
        exit;
    } else {
        $error = 'Nombre de usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
