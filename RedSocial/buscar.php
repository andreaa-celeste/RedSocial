<?php
$cadena_conexion = 'mysql:host=127.0.0.1;dbname=redsocial;charset=utf8';
$usuario = 'root';
$clave = '';

try {
    $pdo = new PDO($cadena_conexion, $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// esto es para hacer la busqueda
$resultados = [];
if (isset($_POST['buscar'])) {
    $termino = $_POST['termino'];
    $sql = "SELECT * FROM Usuario 
            WHERE nombre LIKE :termino 
               OR ciudad LIKE :termino 
               OR biografia LIKE :termino";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['termino' => "%$termino%"]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Usuarios</title>
</head>
<body>
        <link rel="stylesheet" href="CSS/buscar.css">

    <h2>Buscador</h2>
    <form method="POST">
        <input type="text" name="termino" placeholder="Buscar por nombre" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if (!empty($resultados)): ?>
        <h3>Resultados:</h3>
        <ul>
            <?php foreach ($resultados as $usuario): ?>
                <li>
                    <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong><br>
                    Ciudad: <?php echo htmlspecialchars($usuario['ciudad']); ?><br>
                    Biografía: <?php echo htmlspecialchars($usuario['biografia']); ?><br>
                    Género: <?php echo htmlspecialchars($usuario['genero']); ?><br>
                    Email: <?php echo htmlspecialchars($usuario['email']); ?>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($_POST['buscar'])): ?>
        <p>No se encontraron usuarios.</p>
    <?php endif; ?>
</body>
</html>
