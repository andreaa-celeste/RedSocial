<?php
require_once "../BD/bd.php";
require_once "../ACCESO/procesa.php";

$sql = "SELECT u.id_usuario, u.nombre
        FROM Seguir_Usuario s
        JOIN Usuario u ON s.id_seguidor = u.id_usuario
        WHERE s.id_seguido = :yo
        AND s.estado = 'pendiente'";

$solicitudes = $bd->prepare($sql);
$solicitudes->execute([':yo' => $_SESSION['idusu']]);

echo "<h1>Solicitudes de seguimiento</h1>";

if ($solicitudes->rowCount() == 0) {
    echo "<p>No tienes solicitudes pendientes.</p>";
    echo "<a href='../ZONAUSU/perfil_propio.php'>Volver a mi perfil</a>";
    exit;
}

foreach ($solicitudes as $solicitud) {
    echo "<div style='margin-bottom:10px;'>";
    echo "<strong>{$solicitud['nombre']}</strong> ";
    echo "<a href='aceptar.php?id={$solicitud['id_usuario']}'>Aceptar</a> ";
    echo "<a href='rechazar.php?id={$solicitud['id_usuario']}'>Rechazar</a>";
    echo "</div>";
}

echo "<br><a href='../ZONAUSU/perfil_propio.php'>Volver a mi perfil</a>";
