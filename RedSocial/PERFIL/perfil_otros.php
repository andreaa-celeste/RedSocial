<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $usuario = 'root';
    $clave = '';

    $bd = new PDO($cadena_conexion, $usuario, $clave);
    ?>
</body>

</html>