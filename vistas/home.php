<?php
// 1. Verificación de seguridad: Si no hay un ID de usuario en la sesión, el usuario no ha pasado por el login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit();
}
?>

<div style="text-align: center; margin-top: 50px;">
    <h1>¡Bienvenido al Sistema, <?php echo $_SESSION['usuario_nombre']; ?>!</h1>
    <p>Has iniciado sesión correctamente.</p>
    <a href="index.php?vista=taxis">Ir a Taxis</a>
</div>