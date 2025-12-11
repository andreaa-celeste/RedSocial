<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="">
    <title>Buscar</title>
</head>

<body>
    <?php
    require_once "../BD/bd.php";
    require_once "cabecera.php";
    ?>
    <h2>Buscar perfiles</h2>

    <form method="POST" action="">
        <input type="text" name="usuBus" placeholder="Nombre de usuario">
        <input type="submit" value="Buscar">
    </form>

    <?php
    if (!empty($_POST["usuBus"])) {

        $sql = "SELECT * FROM usuario WHERE nombre LIKE :busqueda ORDER BY nombre ASC";
        $filas = $bd->prepare($sql);
        $filas->execute([':busqueda' => $_POST["usuBus"] . "%"]);

        foreach ($filas as $fila) {
            echo "<a href='perfil_otros.php?id=" . $fila["id_usuario"] . "'>
            <img src='" . $fila["foto_perfil"] . "' width='80'>
            " . $fila["nombre"] . "
          </a><br>";
        }
    }
    ?>
</body>

</html>