<?php
$conexion = new mysqli("localhost", "root", "", "redsocial");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// busqueda
$busqueda = isset($_GET['q']) ? $conexion->real_escape_string($_GET['q']) : '';

$sql = "SELECT nombre, email FROM usuarios WHERE nombre LIKE '%$busqueda%' ORDER BY nombre ASC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar perfiles</title>
    <link rel="stylesheet" href="CSS/cabecera.css">
</head>
<body>
    <?php include("cabecera.php"); ?>

    <main>
        <h2>Buscar perfiles</h2>
        <form method="get" action="buscar.php">
            <input type="text" name="q" placeholder="Nombre de usuario" value="<?= htmlspecialchars($busqueda) ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <section>
            <?php if ($busqueda): ?>
                <h3>Resultados para "<?= htmlspecialchars($busqueda) ?>"</h3>
                <?php if ($resultado->num_rows > 0): ?>
                    <ul>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <li>
                                <strong><?= htmlspecialchars($fila['nombre']) ?></strong><br>
                                <small><?= htmlspecialchars($fila['email']) ?></small>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No se encontraron perfiles.</p>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>