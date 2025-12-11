<?php
session_start();

$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
$usuario = 'root';
$clave = '';

$bd = new PDO($cadena_conexion, $usuario, $clave);

if (isset($_POST["usu"]) && isset($_POST["cla"])) {

    $sql = "SELECT * FROM usuario WHERE email='" . $_POST["usu"] . "'";
    $filas = $bd->query($sql);

    if ($filas->rowCount() == 0) {
        header("Location: login.php?error=1");
    } else {
        foreach ($filas as $fila) {
            if (password_verify($_POST["cla"], $fila["contraseña"])) {
                $_SESSION["logueado"] = $fila["email"];
                $_SESSION["rol"] = $fila["rol"];

                if ($_SESSION["rol"] == "usuario")
                    header("Location: usuarios.php");
                else
                    header("Location: zonaadmin.php");
            } else {
                header("Location: login.php?error=1");
            }
        }
    }
}