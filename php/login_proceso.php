<?php
// login_proceso.php
// Iniciamos la sesión para poder guardar al usuario en el sistema
session_start();
// Ajustamos la inclusión usando el archivo exacto que ya revisamos
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario de login
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        // Redirigimos a través del index usando tu sistema de vistas
        header("Location: index.php?vista=login&error=campos_vacios");
        exit();
    }

    try {
        // CORRECCIÓN 1: Usamos la columna real de tu SQL ('usuario_usuario')
        $sql = "SELECT * FROM usuario WHERE usuario_usuario = :user LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $usuario = $stmt->fetch();

        // Si el usuario existe, pasamos a validar la contraseña
        if ($usuario) {
            // CORRECCIÓN 2: Usamos la columna real de tu SQL ('usuario_clave')
            // Se queda con comparación simple (texto plano) ideal para entornos escolares
            if ($password == $usuario['usuario_clave']) {
                
                // ¡Credenciales correctas! Guardamos los datos reales en la sesión
                $_SESSION['usuario_id'] = $usuario['usuario_id'];
                $_SESSION['usuario_nombre'] = $usuario['usuario_nombre'];
                $_SESSION['usuario_usuario'] = $usuario['usuario_usuario'];
                $_SESSION['logueado']   = true;

                // CORRECCIÓN 3: Redirigimos al index pasándole la vista del panel principal (por ejemplo: 'home')
                header("Location: index.php?vista=home");
                exit();
            } else {
                // Contraseña incorrecta
                header("Location: index.php?vista=login&error=password_incorrecto");
                exit();
            }
        } else {
            // El usuario no existe en la BD
            header("Location: index.php?vista=login&error=no_existe");
            exit();
        }

    } catch (\PDOException $e) {
        header("Location: index.php?vista=login&error=db&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: index.php?vista=login");
    exit();
}
?>