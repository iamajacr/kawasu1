<?php

include_once "conexion.php";

// Verificamos que los datos vengan por el método POST del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibimos y limpiamos los datos del formulario
    // Ajusta los nombres dentro de [''] si en tu HTML se llaman diferente
    $numero_economico = trim($_POST['numero_economico']);
    $placas           = trim($_POST['placas']);
    $modelo           = trim($_POST['modelo']);
    $id_permisionario = trim($_POST['id_permisionario']); // La llave foránea
    $estado           = "Activo"; // Estado inicial por defecto

    // Validamos que los campos obligatorios no estén vacíos
    if (empty($numero_economico) || empty($placas) || empty($id_permisionario)) {
        // Si falta algo, redirige de vuelta con un error por URL
        header("Location: vistas/taxis.php?status=campos_vacios");
        exit();
    }

    try {
        // Preparamos la consulta SQL con marcadores (seguridad nativa gracias a tu conexión)
        // NOTA: Ajusta los nombres de las columnas (numero_economico, placas, etc.) 
        // para que coincidan exactamente con cómo los escribiste en phpMyAdmin.
        $sql = "INSERT INTO taxi (numero_economico, placas, modelo, id_permisionario, estado) 
                VALUES (:num_eco, :placas, :modelo, :id_permisionario, :estado)";
        
        $stmt = $pdo->prepare($sql);

        // Vinculamos los parámetros
        $stmt->bindParam(':num_eco', $numero_economico, PDO::PARAM_STR);
        $stmt->bindParam(':placas', $placas, PDO::PARAM_STR);
        $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt->bindParam(':id_permisionario', $id_permisionario, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Si todo sale bien, redirige al panel de taxis con éxito
            header("Location: vistas/taxis.php?status=success");
        } else {
            header("Location: vistas/taxis.php?status=error");
        }
        exit();

    } catch (\PDOException $e) {
        // Si truena (por ejemplo, si meten un número económico o placa que ya existe)
        // redirige mostrando el mensaje de error de la base de datos
        header("Location: vistas/taxis.php?status=error_db&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    
    header("Location: vistas/taxis.php");
    exit();
}
?>