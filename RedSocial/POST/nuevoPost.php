<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Post</title>
</head>

<body>
    <?php
    require_once "../BD/bd.php";
    require_once "../ACCESO/procesa.php";
    ?>
    <h2>Nuevo Post</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <textarea name="contenido_texto" placeholder="Escribe algo" rows="4" cols="50"></textarea><br><br>

        <label>Imagen (opcional):</label>
        <input type="file" name="imagen"><br><br>

        <label>Archivo adjunto (opcional):</label>
        <input type="file" name="archivo"><br><br>

        <input type="submit" value="Publicar">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $contenido_texto = trim($_POST['contenido_texto']);

        if ($contenido_texto === '') {
            echo "<p style='color:red;'>Debes escribir algo para publicar un post.</p>";
            exit;
        }

        $imagen_url = null;
        $archivo_url = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagen_url = "../IMG/" . basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "../IMG/" . $imagen_url);
        }

        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
            $archivo_url = "../ARCHIVOS/" . basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo_url);
        }

        $sql = "INSERT INTO post (id_usuario, contenido_texto, imagen, archivo_adjunto) 
            VALUES (:id_usuario, :contenido_texto, :imagen, :archivo)";
        $sentencia = $bd->prepare($sql);
        $sentencia->execute([
            ':id_usuario' => $_SESSION["idusu"],
            ':contenido_texto' => $contenido_texto,
            ':imagen' => $imagen_url,
            ':archivo' => $archivo_url
        ]);

        header("Location: ../ZONAUSU/perfil_propio.php");
        exit;
    }
    ?>
</body>

</html>