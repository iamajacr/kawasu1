<?php
    // Iniciar sesión para controlar los usuarios administradores
    session_start();
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
        // 1. Incluir la barra de navegación que está en la carpeta inc/
        if(file_exists("./inc/nav.php")){
            include "./inc/nav.php";
        }

        // 2. Sistema de enrutamiento simple (lo que explica el curso)
        // Si no se solicita ninguna vista, por defecto cargamos el 'login' o el 'home'
        $vista = isset($_GET['vista']) ? $_GET['vista'] : 'login';

        // Validamos que el archivo de la vista realmente exista antes de incluirlo
        if(file_exists("./vistas/".$vista.".php")){
            include "./vistas/".$vista.".php";
        } else {
            echo "<h2>Error 404: La página no existe</h2>";
        }
    ?>

</body>
</html>