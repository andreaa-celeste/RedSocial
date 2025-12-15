<?php
require_once "../BD/bd.php";
require_once "../ACCESO/procesa.php";

$sql = "UPDATE Seguir_Usuario
        SET estado = 'aceptado'
        WHERE id_seguidor = :seguidor
        AND id_seguido = :yo";

$prep = $bd->prepare($sql);
$prep->execute([
    ':seguidor' => $_GET['id'],
    ':yo' => $_SESSION['idusu']
]);

header("Location: solicitudes.php");
exit;