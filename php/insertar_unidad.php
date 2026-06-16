<?php
include_once "conexion.php";

// Verificación de conexión segura usando tu variable real ($pdo)
if (!isset($pdo) || $pdo === null) {
    header("Location: index.php?status=error_conexion");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$numero_economico = trim($_POST['numero_economico'] ?? '');
$placas           = trim($_POST['placas'] ?? '');
$modelo           = trim($_POST['modelo'] ?? '');
$chofer           = trim($_POST['chofer'] ?? '');
$estado           = "Activo";

if (empty($numero_economico) || empty($placas)) {
    header("Location: index.php?status=error_campos");
    exit();
}

try {
    $sql = "INSERT INTO unidades (numero_economico, placas, modelo, chofer, estado)
            VALUES (:num_eco, :placas, :modelo, :chofer, :estado)";

    // Usamos $pdo correctamente
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':num_eco', $numero_economico, PDO::PARAM_STR);
    $stmt->bindParam(':placas', $placas, PDO::PARAM_STR);
    $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
    $stmt->bindParam(':chofer', $chofer, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

    $stmt->execute();

    header("Location: index.php?status=success");
    exit();

} catch (PDOException $e) {
    // Guarda el error en el log de XAMPP para que tú lo revises
    error_log("Error al insertar unidad: " . $e->getMessage());
    
    header("Location: index.php?status=error_db&msg=" . urlencode($e->getMessage()));
    exit();
}
?>