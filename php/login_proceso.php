<?php
session_start();
require_once "conexion.php";

$usuario = trim($_POST['username']);
$password = $_POST['password'];

// Consultamos al usuario
$stmt = $pdo->prepare("SELECT * FROM usuario WHERE usuario_usuario = :usuario");
$stmt->execute([':usuario' => $usuario]);
$datos = $stmt->fetch();

if ($datos) {
    // CAMBIO AQUÍ: Comparamos directamente. 
    // Si esto funciona, es porque tus contraseñas NO están cifradas con password_hash.
    if ($password == $datos['usuario_clave']) {
        $_SESSION['usuario_id'] = $datos['usuario_id'];
        header("Location: ../index.php?vista=home");
        exit();
    } else {
        // Si sigue fallando aquí, es que la contraseña escrita no es igual a la de la BD
        header("Location: ../index.php?vista=login&error=password_incorrecto");
        exit();
    }
} else {
    header("Location: ../index.php?vista=login&error=no_existe");
    exit();
}
?>