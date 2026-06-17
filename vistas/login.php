<?php
// 1. Verificación: Si ya hay una sesión activa, enviamos al usuario al home directamente
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=home");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Ecotaxis Verde</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #1e5631; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #4caf50; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; cursor: pointer; }
        .error { color: #721c24; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Iniciar Sesión</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php 
                if ($_GET['error'] == 'password_incorrecto') echo "Contraseña incorrecta.";
                elseif ($_GET['error'] == 'no_existe') echo "El usuario no existe.";
                elseif ($_GET['error'] == 'campos_vacios') echo "Completa todos los campos.";
            ?>
        </div>
    <?php endif; ?>

    <form action="php/login_proceso.php" method="POST">
        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
</div>
</body>
</html>