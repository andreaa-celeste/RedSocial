<?php
require_once "../BD/bd.php";

if (isset($_GET["token"])) {
    $sql = "INSERT INTO Usuario(email, contraseña, nombre, fecha_nacimiento, genero)
        SELECT email, contraseña, nombre, fecha_nacimiento, genero
        FROM registro_pendiente
        WHERE token = :token";
    $preparada = $bd->prepare($sql);
    $preparada->execute([':token' => $_GET["token"]]);

    if ($preparada->rowCount() > 0) {
        $sql = "DELETE FROM registro_pendiente WHERE token = :token";
        $preparada2 = $bd->prepare($sql);
        $preparada2->execute([':token' => $_GET["token"]]);
        echo "Cuenta validada y creada correctamente.";
        echo "<a href='login.php'>Inicia Sesión</a>";
    } else {
        echo "Token inválido o ya usado.";
        echo "<a href='login.php'>Volver</a>";
    }
}
