<?php
session_start();
require_once "../bd/procesa.php";  // AJUSTA si tu conexión está en otra ruta

// Si no está logueado, se manda al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

// Obtener todos los usuarios
$consulta = "SELECT id, nombre, email FROM usuarios ORDER BY nombre ASC";
$resultado = $conexion->query($consulta);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>

<h2>Usuarios registrados</h2>

<a href="../index.php">Volver al inicio</a> |
<a href="../logout.php">Cerrar sesión</a>

<hr>

<?php
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
?>
        <div class="user-card">
            <p><strong><?= htmlspecialchars($fila['nombre']); ?></strong></p>
            <p><?= htmlspecialchars($fila['email']); ?></p>

            <a class="btn" href="../perfil.php?id=<?= $fila['id']; ?>">Ver perfil</a>
        </div>
<?php
    }
} else {
    echo "<p>No hay usuarios registrados.</p>";
}
?>

</body>
</html>
