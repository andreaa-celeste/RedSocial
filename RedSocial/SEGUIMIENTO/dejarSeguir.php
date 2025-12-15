<?php
require_once "../BD/bd.php";
require_once "../ACCESO/procesa.php";

$sql = "DELETE FROM Seguir_Usuario
        WHERE id_seguidor = :yo
        AND id_seguido = :otro";

$prep = $bd->prepare($sql);
$prep->execute([
    ':yo' => $_SESSION['idusu'],
    ':otro' => $_GET['id']
]);

header("Location: ../ZONAUSU/perfil_otros.php?id=" . $_GET['id']);
exit;