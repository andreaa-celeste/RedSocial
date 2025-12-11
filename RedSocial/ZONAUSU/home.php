<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/home.css">
</head>

<body>
    <?php
    require_once "cabecera.php";
    require_once "../ACCESO/procesa.php";
    require_once "../BD/bd.php";

    $sql = "SELECT * FROM usuario WHERE email != :email";

    $filas = $bd->prepare($sql);
    $filas->execute([':email' => $_SESSION["logueado"]]);
    ?>
    <h1>Usuarios</h1>

    <?php
    foreach ($filas as $fila) {
        echo "<a href='perfil_otros.php?id=" . $fila["id_usuario"] . "'>
            <img src='" . $fila["foto_perfil"] . "' width='80'>
            " . $fila["nombre"] . "
          </a><br>";
    }
    ?>
</body>

</html>