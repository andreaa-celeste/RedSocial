<?php
use PHPMailer\PHPMailer\PHPMailer;
require "vendor/autoload.php";

if (isset($_POST["nom"], $_POST["mail"], $_POST["contraseña"])) {
$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';

$usuario = 'root';
$clave = '';
$bd = new PDO($cadena_conexion, $usuario, $clave);
$sqlCheck = "SELECT id_usuario FROM Usuario WHERE email = :mail";
$stmtCheck = $bd->prepare($sqlCheck);
$stmtCheck->execute([':mail' => $_POST["mail"]]);

    if ($stmtCheck->rowCount() > 0) {
    echo "Este correo ya está registrado. Intenta con otro.";
    } else {
    $token = bin2hex(random_bytes(16));

$sql = "INSERT INTO registro_pendiente(nombre,email,contraseña,fecha_nacimiento,genero,token) 
  VALUES(:nom,:mail,:pass,:cumple,:genero,:token)";
    $stmt = $bd->prepare($sql);

        $stmt->execute([
    ':nom' => $_POST["nom"],
    ':mail' => $_POST["mail"],
    ':pass' => password_hash($_POST["contraseña"], PASSWORD_DEFAULT),
    ':cumple' => $_POST["cumple"],
    ':genero' => $_POST["genero"],
    ':token' => $token
     ]);

        $enlace = "http://localhost/RedSocial/validar.php?token=$token";

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->Username = 'c93eb5f54393a9';
        $mail->Password = 'b550b3a8e99e19';
        $mail->SetFrom('noreply@redsocial.com', 'Registro RedSocial');
        $mail->AddAddress($_POST["mail"]);
        $mail->Subject = "Valida tu registro";
        $mail->MsgHTML("<h1>Bienvenido, " . $_POST["nom"] . "</h1>

                    <p>Haz clic en el siguiente enlace para validar tu cuenta:</p>

                    <a href='$enlace'>$enlace</a>");

        $mail->Send();
        echo "Revisa tu correo para validar la cuenta.";

    }

} else {

    echo "Faltan Datos";

}