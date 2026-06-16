<?php
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: vistas/taxis.php");
    exit();
}

// Recibir y limpiar datos
$numero_economico = trim($_POST['numero_economico'] ?? '');
$placas           = trim($_POST['placas'] ?? '');
$modelo           = trim($_POST['modelo'] ?? '');
$id_permisionario  = trim($_POST['id_permisionario'] ?? '');

$estado = "Activo";

// Validaciones
$errores = [];

if (empty($numero_economico)) {
    $errores[] = "numero_economico";
}
if (empty($placas)) {
    $errores[] = "placas";
}
if (!is_numeric($id_permisionario) || $id_permisionario <= 0) {
    $errores[] = "id_permisionario";
}

if (!empty($errores)) {
    header("Location: vistas/taxis.php?status=campos_vacios&campos=" . implode(',', $errores));
    exit();
}

try {
    $sql = "INSERT INTO taxi (numero_economico, placas, modelo, id_permisionario, estado)
            VALUES (:num_eco, :placas, :modelo, :id_permisionario, :estado)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':num_eco', $numero_economico, PDO::PARAM_STR);
    $stmt->bindParam(':placas', $placas, PDO::PARAM_STR);
    $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
    $stmt->bindParam(':id_permisionario', $id_permisionario, PDO::PARAM_INT);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: vistas/taxis.php?status=success");
    } else {
        header("Location: vistas/taxis.php?status=error");
    }
    exit();

} catch (\PDOException $e) {
    // Mensajes más amigables según el tipo de error
    $mensaje = $e->getMessage();
    
    if (strpos($mensaje, 'Duplicate entry') !== false) {
        header("Location: vistas/taxis.php?status=duplicado");
    } else {
        header("Location: vistas/taxis.php?status=error_db");
    }
    exit();
}
?>