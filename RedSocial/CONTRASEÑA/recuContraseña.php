<?php
session_start();
require_once "../BD/bd.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    
    $sql = "SELECT id_usuario FROM Usuario WHERE email = :email";
    $sql = $bd->prepare($sql);
    $sql->execute([':email' => $email]);

    if ($usuario) {

        $token = bin2hex(random_bytes(50));

        
        $sql = "UPDATE Usuario SET reset_token = :token, reset_expires = :expira WHERE email = :email";
        $sql = $bd->prepare($sql);
        $sql->execute([
            ':token' => $token,
            ':expira' => $expira,
            ':email' => $email
        ]);

    
        $link = "http://localhost/RedSocial/CONTRASEÑA/reset_contraseña.php?token=". $token;

        mail($email, "Recuperar tu contraseña", "Haz clic aquí para restablecerla: $link");

        echo "Si el correo existe, recibirás un enlace de recuperación.";
    } else {
        echo "Si el correo existe, recibirás un enlace de recuperación."; 
    }
}
?>

<form method="post">
    <input type="email" name="email" placeholder="Introduce tu correo" required>
    <button type="submit">Recuperar contraseña</button>
</form>