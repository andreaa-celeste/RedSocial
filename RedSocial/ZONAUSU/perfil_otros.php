<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfil de usuario</title>
</head>

<body>
    <?php
    require_once "cabecera.php";
    require_once "../BD/bd.php";
    require_once "../ACCESO/procesa.php";

    $id_usuario = $_GET['id'];

    $sqlSeg = "SELECT estado FROM Seguir_Usuario
           WHERE id_seguidor = :yo
           AND id_seguido = :otro";

    $prepSeg = $bd->prepare($sqlSeg);
    $prepSeg->execute([
        ':yo' => $_SESSION['idusu'],
        ':otro' => $id_usuario
    ]);

    $seguimiento = null;

    foreach ($prepSeg as $row) {
        $seguimiento = $row;
    }
    if ($id_usuario != $_SESSION['idusu']) {

        if (!$seguimiento) {
            echo "<a href='../SEGUIMIENTO/seguir.php?id=$id_usuario'>Seguir</a>";
        } elseif ($seguimiento['estado'] == 'pendiente') {
            echo "<p>Solicitud enviada</p>";
        } elseif ($seguimiento['estado'] == 'aceptado') {
            echo "<a href='../SEGUIMIENTO/dejarSeguir.php?id=$id_usuario'>Dejar de seguir</a>";
        }
    }
    ?>

    <h1>Perfil</h1>

    <?php
    $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
    $filas = $bd->prepare($sql);
    $filas->execute([':id' => $id_usuario]);

    foreach ($filas as $fila) {
        echo "
        <img src='{$fila['foto_perfil']}' width='120'><br><br>

        <strong>Nombre:</strong> {$fila['nombre']}<br>
        <strong>Fecha de nacimiento:</strong> {$fila['fecha_nacimiento']}<br>
        <strong>Ciudad:</strong> {$fila['ciudad']}<br>
        <strong>Biografía:</strong> {$fila['biografia']}<br>
        ";
    }
    ?>

    <h2>POST</h2>

    <?php
    if ($seguimiento && $seguimiento['estado'] == 'aceptado') {

        $sql2 = "SELECT * FROM post WHERE id_usuario = :id_usuario ORDER BY fecha_publicacion DESC";
        $preparada = $bd->prepare($sql2);
        $preparada->execute([':id_usuario' => $id_usuario]);

        foreach ($preparada as $post) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:15px;'>";
            echo "<p>" . nl2br($post['contenido_texto']) . "</p>";

            if (!empty($post['imagen'])) {
                echo "<img src='{$post['imagen']}' width='200'><br>";
            }

            if (!empty($post['archivo_adjunto'])) {
                echo "<a href='{$post['archivo_adjunto']}'>Ver archivo adjunto</a><br>";
            }

            echo "<small>Publicado el: {$post['fecha_publicacion']}</small><br><br>";
            echo "<a href='../POST/verPost.php?id={$post['id_post']}'>Ver comentarios</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Debes seguir a este usuario y que acepte tu solicitud para ver sus posts.</p>";
    }
    ?>
</body>

</html>