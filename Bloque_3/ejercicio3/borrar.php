<?php
setcookie('idioma', '', time() - 3600, "/");
setcookie('tema', '', time() - 3600, "/");

header('Location: index.php');
exit();