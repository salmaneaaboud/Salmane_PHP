<?php
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['boton_borrar'])) {
            session_unset();
            session_destroy();
            header("Refresh:0");
        }
    } else {
        if (!isset($_SESSION["visitas"])) {
            $_SESSION["visitas"] = 0;
        } else {
            $_SESSION["visitas"]++;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
        <input type="submit" value="Borrar sesión" name="boton_borrar">
    </form>
    <?php
    if ($_SESSION["visitas"] == 0) {
        echo "Es tu primera visita";
    } else {
        echo "Es tu visita número " . ($_SESSION["visitas"]+1);
    }
    ?>
</body>

</html>