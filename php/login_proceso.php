<?php
// login_proceso.php
// Iniciamos la sesión para poder guardar al usuario en el sistema
session_start();
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario de login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=campos_vacios");
        exit();
    }

    try {
        // Buscamos al usuario en la base de datos
        // NOTA: Ajusta 'nombre_usuario' y 'contrasena' según tus columnas de la tabla 'usuario'
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = :user LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $usuario = $stmt->fetch();

        // Si el usuario existe, pasamos a validar la contraseña
        if ($usuario) {
            // NOTA: Si estás guardando las contraseñas en texto plano (para la escuela), 
            // usa la comparación simple: if ($password == $usuario['contrasena'])
            // Si usaste password_hash(), usa: if (password_verify($password, $usuario['contrasena']))
            if ($password == $usuario['contrasena']) {
                
                // ¡Credenciales correctas! Guardamos los datos en la sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre']     = $usuario['nombre_usuario'];
                $_SESSION['logueado']   = true;

                // Redirigimos al panel principal (ajusta la ruta a tu index o dashboard)
                header("Location: vistas/dashboard.php");
                exit();
            } else {
                // Contraseña incorrecta
                header("Location: login.php?error=password_incorrecto");
                exit();
            }
        } else {
            // El usuario no existe en la BD
            header("Location: login.php?error=no_existe");
            exit();
        }

    } catch (\PDOException $e) {
        header("Location: login.php?error=db&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
