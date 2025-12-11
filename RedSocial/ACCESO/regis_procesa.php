<?php
use PHPMailer\PHPMailer\PHPMailer;
require "../vendor/autoload.php";
require_once "../BD/bd.php";

if (isset($_POST["nom"], $_POST["mail"], $_POST["contraseña"])) {
    $sql = "SELECT id_usuario FROM Usuario WHERE email = :mail";
    $preparada = $bd->prepare($sql);
    $preparada->execute([':mail' => $_POST["mail"]]);

    if ($preparada->rowCount() > 0) {
        echo "Este correo ya está registrado. Intenta con otro.";

    } else {
        $token = bin2hex(random_bytes(16));

        $sql = "INSERT INTO registro_pendiente(nombre,email,contraseña,fecha_nacimiento,genero,token) 
            VALUES(:nom,:mail,:pass,:cumple,:genero,:token)";
        $hash = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
        $preparada2 = $bd->prepare(query: $sql);
        $preparada2->execute([
            ':nom' => $_POST["nom"],
            ':mail' => $_POST["mail"],
            ':pass' => $hash,
            ':cumple' => $_POST["cumple"] ?? null,
            ':genero' => $_POST["genero"] ?? null,
            ':token' => $token
        ]);

        $enlace = "http://localhost/RedSocial/ACCESO/validar.php?token=$token";

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->Username = '7f1c9b9359c8dc';
        $mail->Password = 'de6bead9adc552';
        $mail->SetFrom('noreply@redsocial.com', 'Registro RedSocial');
        $mail->AddAddress($_POST["mail"]);
        $mail->Subject = "Valida tu registro";
        $mail->MsgHTML("<h1>Bienvenid@, " . $_POST["nom"] . "</h1>
                    <p>Haz clic en el siguiente enlace para validar tu cuenta:</p>
                    <a href='$enlace'>$enlace</a>");
        $mail->Send();

        echo "Revisa tu correo para validar la cuenta.";
    }
} else {
    echo "Faltan Datos";
}