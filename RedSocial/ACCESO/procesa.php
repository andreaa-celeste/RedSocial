<?php
session_start();

require_once "../BD/bd.php";

if (isset($_POST["usu"]) && isset($_POST["cla"])) {
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $filas = $bd->prepare($sql);
    $filas->execute([':email' => $_POST["usu"]]);

    if ($filas->rowCount() == 0) {
        header("Location: login.php?error=1");
    } else {
        foreach ($filas as $fila) {
            if (password_verify($_POST["cla"], $fila["contraseña"])) {
                $_SESSION["logueado"] = $fila["email"];
                $_SESSION["idusu"] = $fila["id_usuario"];
                $_SESSION["rol"] = $fila["rol"];

                if ($_SESSION["rol"] == "usuario") {
                    header("Location: ../ZONAUSU/home.php");
                } else {
                    header("Location: ../ZONAADMIN/zonaadmin.php");
                }
                exit;
            } else {
                header("Location: login.php?error=1");
                exit;
            }
        }

    }
}
