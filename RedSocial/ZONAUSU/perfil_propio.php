<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mi perfil</title>
</head>

<body>
    <?php
    require_once "cabecera.php";
    require_once "../BD/bd.php";
    require_once "../ACCESO/procesa.php";
    ?>
    <h1>Mi perfil</h1>

    <?php
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $filas = $bd->prepare($sql);
    $filas->execute([':email' => $_SESSION["logueado"]]);

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
    <a href="modificar.php">Modificar</a>
    <a href="../POST/nuevoPost.php">Nuevo Post</a>
    <h2>POST</h2>

    <?php
    $sql2 = "SELECT * FROM post 
         WHERE id_usuario = :id_usuario 
         ORDER BY fecha_publicacion DESC";

    $preparada2 = $bd->prepare($sql2);
    $preparada2->execute([':id_usuario' => $_SESSION["idusu"]]);

    foreach ($preparada2 as $post) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:15px;'>";
        echo "<p>" . nl2br($post['contenido_texto']) . "</p>";
        if (!empty($post['imagen'])) {
            echo "<img src='" . $post['imagen'] . "' width='200'><br>";
        }
        if (!empty($post['archivo_adjunto'])) {
            echo "<a href='" . $post['archivo_adjunto'] . "'>ver archivo adjunto</a><br>";
        }
        echo "<small>Publicado el: " . $post['fecha_publicacion'] . "</small><br><br>";
        echo "<a href='../POST/verPost.php?id=" . $post['id_post'] . "'>Ver Comentarios</a>";
        echo "<a href='../POST/borrar.php?id=" . $post['id_post'] . "'>Borrar</a>";
        echo "</div>";
    }
    ?>
</body>

</html>