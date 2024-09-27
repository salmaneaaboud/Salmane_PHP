<?php
if (isset($_COOKIE['idioma']) && isset($_COOKIE['tema'])) {
    $idioma = $_COOKIE['idioma'];
    $tema = $_COOKIE['tema'];
} else {
    $idioma = ''; 
    $tema = ''; 
}

$bienvenidaEuskara = 'Ongi etorri!';
$bienvenidaCastellano = '¡Bienvenido!';

if ($tema === 'Oscuro') {
    $backgroundClass = 'bg-gradient-dark'; 
    $textColor = '#FFF';
} else {
    $backgroundClass = 'bg-gradient-light'; 
    $textColor = '#000';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Ejercicio 3</title>
    <style>
        body {
            color: <?php echo $textColor; ?>;
        }

        .bg-gradient-light {
            background: linear-gradient(to right, #C9D6FF, #E2E2E2); 
        }

        .bg-gradient-dark {
            background: linear-gradient(to right, #000000, #434343); 
        }
    </style>
</head>

<body class=<?php echo $backgroundClass;?>>
    <div class="container mt-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1>
                    <?php 
                    if (!isset($_COOKIE['idioma'])) echo "$bienvenidaEuskara / $bienvenidaCastellano";
                    elseif ($idioma=='Euskara') echo $bienvenidaEuskara;
                    else echo $bienvenidaCastellano;
                    ?>
                </h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="post" action="guardar.php">
                    <div class="mb-3">
                        <label for="idioma" class="form-label">Idioma:</label>
                        <select name="idioma" id="idioma" class="form-select">
                            <option value="" disabled selected>Selecciona un idioma</option>
                            <option value="Euskara" <?php if ($idioma === 'Euskara') echo 'selected'; ?>>Euskara</option>
                            <option value="Castellano" <?php if ($idioma === 'Castellano') echo 'selected'; ?>>Castellano</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tema" class="form-label">Tema:</label>
                        <select name="tema" id="tema" class="form-select">
                            <option value="" disabled selected>Selecciona un tema</option>
                            <option value="Oscuro" <?php if ($tema === 'Oscuro') echo 'selected'; ?>>Oscuro</option>
                            <option value="Claro" <?php if ($tema === 'Claro') echo 'selected'; ?>>Claro</option>
                        </select>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
                <form method="post" action="borrar.php">
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-danger">Borrar Cookies</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
