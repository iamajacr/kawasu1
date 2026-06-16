<?php
// consultar_unidades.php
include_once "conexion.php";

try {
    // Traemos todas las unidades ordenadas por su número económico
    $sql = "SELECT * FROM unidades ORDER BY numero_economico ASC";
    $stmt = $conexion->query($sql);
    $unidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al consultar las unidades: " . $e->getMessage();
    $unidades = [];
}
?>