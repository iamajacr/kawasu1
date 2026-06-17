<?php
// ... (tu código de validación de base de datos) ...

// Si el usuario es correcto, usa esta línea para redirigir:
header("Location: ../index.php?vista=home");
exit();

// Si el usuario falla (ejemplo: contraseña incorrecta), usa esta:
header("Location: ../index.php?vista=login&error=password_incorrecto");
exit();
?>