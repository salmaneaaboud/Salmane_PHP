<!DOCTYPE HTML>
<html>
<body>
    <?php
        $value = $_GET["fnum"];
        $random_value = random_int(1,5);
        if ($random_value == $value) {
            echo "Has acertado. Número introducido: ".$value.". Número random: ".$random_value;
        } else {
            echo "No has acertado. Número introducido: ".$value.". Número random: ".$random_value;
        }
    ?>
</body>
</html>