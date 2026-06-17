<?php
// php/cerrar_sesion.php
session_start(); // Inicia la sesión para poder destruirla
session_unset(); // Libera todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// Redirige al usuario a la página principal (que mostrará el login por defecto)
header("Location: ../index.php");
exit();
?>