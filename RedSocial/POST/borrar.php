<?php
require_once "../ACCESO/procesa.php";
require_once "../BD/bd.php";

$sql = "SELECT * FROM post WHERE id_post = :id_post AND id_usuario = :id_usuario";
$filas = $bd->prepare($sql);
$filas->execute([
    ":id_post" => $_GET["id"],
    ":id_usuario" => $_SESSION["idusu"]
]);
foreach ($filas as $fila) {
    if (!empty($fila["imagen"]) && file_exists($fila["imagen"])) {
        unlink($fila["imagen"]);
    }
    if (!empty($fila["archivo_adjunto"]) && file_exists($fila["archivo_adjunto"])) {
        unlink($fila["archivo_adjunto"]);
    }
}

$sql2 = "DELETE FROM Post WHERE id_post = :id_post";
$borrar = $bd->prepare($sql2);
$borrar->execute([":id_post" => $_GET["id"]]);

header("Location: ../ZONAUSU/perfil_propio.php");
exit;