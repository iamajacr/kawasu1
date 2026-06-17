<?php
// 1. Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Iniciar sesión
session_start();

// 3. Lógica para cerrar sesión (Añadido aquí)
if (isset($_GET['vista']) && $_GET['vista'] == 'logout') {
    session_destroy();
    header("Location: index.php?vista=login");
    exit();
}

// 4. Definición de la vista
$vista = isset($_GET['vista']) ? $_GET['vista'] : 'login';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sindicato de Ecotaxis Verdes</title>
    <link rel="stylesheet" href="css/estilos.css"> 
</head>
<body>

    <?php
    // 5. Incluir navegación
    if ($vista != 'login') {
        if(file_exists("./inc/nav.php")){
            include "./inc/nav.php";
        }
    }

    // 6. Sistema de enrutamiento seguro
    $archivo_vista = "./vistas/" . $vista . ".php";

    if(file_exists($archivo_vista)){
        include $archivo_vista;
    } else {
        if ($vista != 'login') {
            echo "<h2>Error 404: La página no existe</h2>";
        } else {
            include "./vistas/login.php";
        }
    }
    ?>

</body>
</html>