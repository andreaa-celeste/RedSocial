<?php
require_once "../BD/bd.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT * FROM Usuario WHERE reset_token = :token AND reset_expires > NOW()";
    $sql = $bd->prepare($sql);
    $sql->execute([':token' => $token]);

    if ($usuario) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nueva = password_hash($_POST['nueva_contraseña'], PASSWORD_DEFAULT);

            $sql = "UPDATE Usuario SET contraseña = :pass, reset_token = NULL, reset_expires = NULL WHERE reset_token = :token";
            $sql = $bd->prepare($sql);
            $sql->execute([
                ':pass' => $nueva,
                ':token' => $token
            ]);

            echo "Contraseña actualizada";
        } else {
            ?>
            <form method="post">
                <input type="password" name="nueva_contraseña" placeholder="Nueva contraseña" required>
                <button type="submit">Actualizar</button>
            </form>
            <?php
        }
    } else {
        echo "Token inválido o expirado.";
    }
}
?>