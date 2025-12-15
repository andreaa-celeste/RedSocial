<?php
require_once "../ACCESO/procesa.php";
require_once "../BD/bd.php";

$sql = "INSERT INTO Seguir_Usuario (id_seguidor, id_seguido, estado)
        VALUES (:yo, :otro, 'pendiente')";

$prep = $bd->prepare($sql);
$prep->execute([
    ':yo' => $_SESSION['idusu'],
    ':otro' => $_GET['id']
]);

header("Location: ../ZONAUSU/perfil_otros.php?id=" . $_GET['id']);
exit;
