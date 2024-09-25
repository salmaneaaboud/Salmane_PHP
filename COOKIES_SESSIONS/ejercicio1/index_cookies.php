<?php
    $cookie_name = "visitas";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['boton_borrar'])) {
            setcookie($cookie_name, "", time() - 3600);
            header("Refresh:0");
        }
    } else {
        if (!isset($_COOKIE[$cookie_name])) {
            $cookie_value = 0;
        } else {
            $cookie_value = $_COOKIE[$cookie_name];
            $cookie_value++;
        }
    
        setcookie($cookie_name, $cookie_value);
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
        <input type="submit" value="Borrar cookie" name="boton_borrar">
    </form>
    <?php
    if ($cookie_value == 0) {
        echo "Es tu primera visita";
    } else {
        echo "Es tu visita número " . ($cookie_value+1);
    }
    ?>
</body>

</html>