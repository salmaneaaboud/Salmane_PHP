<?php
if (isset($_POST['idioma']) && isset($_POST['tema'])) {
    $idioma = $_POST['idioma'];
    $tema = $_POST['tema'];

    setcookie('idioma', $idioma);
    setcookie('tema', $tema);
}

header('Location: index.php');
exit();