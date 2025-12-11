<?php
session_start();
require_once 'procesa.php'; 


if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?error=sesion");
    exit();
}

$idUsuario = (int)$_SESSION['id_usuario'];

// datos del usuario
$sqlUsuario = "SELECT id_usuario, email, nombre, foto_perfil, fecha_nacimiento,
                      genero, ciudad, biografia, fecha_registro
               FROM Usuario
               WHERE id_usuario = :id";
$prepUsuario = $bd->prepare($sqlUsuario);
$prepUsuario->execute([':id' => $idUsuario]);



