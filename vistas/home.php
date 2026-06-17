<?php
// 1. Verificación de seguridad: Si no hay un ID de usuario en la sesión, el usuario no ha pasado por el login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit();
}
?>

<div style="text-align: center; padding: 40px;">
    <h1>¡Bienvenido al Sistema, Administrador!</h1>
    <p>Has iniciado sesión correctamente.</p>
    
    <div style="margin-top: 20px;">
        <a href="index.php?vista=taxis" style="padding: 10px 20px; background: #4caf50; color: white; text-decoration: none; border-radius: 5px;">Gestionar Taxis</a>
        <a href="index.php?vista=permisionarios" style="padding: 10px 20px; background: #2196f3; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">Gestionar Permisionarios</a>
    </div>
</div>