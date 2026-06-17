<?php
// php/insertar_taxi.php
session_start();
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recorremos y limpiamos los datos enviados desde vistas/taxis.php
    $numero_economico = trim($_POST['taxi_numero_economico'] ?? '');
    $placa            = trim($_POST['taxi_placa'] ?? '');
    $modelo           = trim($_POST['taxi_modelo'] ?? '');
    $año              = trim($_POST['taxi_año'] ?? '');
    $permiso          = trim($_POST['taxi_permiso'] ?? '');
    $permisionario_id = trim($_POST['permisionario_id'] ?? '');
    
    // Rescatamos el ID del usuario administrador que inició sesión (del login_proceso.php)
    $usuario_id       = $_SESSION['usuario_id'] ?? null;

    // Validación básica de campos obligatorios
    if (empty($numero_economico) || empty($placa) || empty($modelo) || empty($año) || empty($permiso) || empty($permisionario_id)) {
        header("Location: ../index.php?vista=taxis&status=campos_vacios");
        exit();
    }

    // Si por alguna razón la sesión expiró o no hay usuario_id, le asignamos el primero por seguridad escolar
    if (!$usuario_id) {
        $usuario_id = 1; 
    }

    try {
        // Preparamos el INSERT apuntando fielmente a tus columnas del SQL
        $sql = "INSERT INTO taxi (taxi_numero_economico, taxi_placa, taxi_modelo, taxi_año, taxi_permiso, permisionario_id, usuario_id) 
                VALUES (:numero_economico, :placa, :modelo, :anio, :permiso, :permisionario_id, :usuario_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':numero_economico' => $numero_economico,
            ':placa'            => $placa,
            ':modelo'           => $modelo,
            ':anio'             => $año,
            ':permiso'          => $permiso,
            ':permisionario_id' => $permisionario_id,
            ':usuario_id'       => $usuario_id
        ]);

        // Si se guarda con éxito, redirigimos de vuelta mostrando la alerta verde
        header("Location: ../index.php?vista=taxis&status=success");
        exit();

    } catch (\PDOException $e) {
        // Si truena por llave foránea o dato duplicado, mandamos el error a la URL de forma segura
        header("Location: ../index.php?vista=taxis&status=error_db&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../index.php?vista=taxis");
    exit();
}
?>