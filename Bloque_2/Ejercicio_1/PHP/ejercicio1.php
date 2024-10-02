<!DOCTYPE HTML>
<html>
<body>
    <?php
        
        if (isset($_POST["num1"]) && isset($_POST["num2"])) {
            $num1 = (int)$_POST["num1"];
            $num2 = (int)$_POST["num2"];
            $suma = $num1 + $num2;
            echo "La suma de $num1 y $num2 es $suma";
        } else {
                echo "Por favor, ingrese ambos números";
        }
    ?>
</body>
</html>