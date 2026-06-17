<?php
// php/consultar_taxis.php
// Incluimos tu archivo de conexión que está en la misma carpeta php/
include_once "conexion.php";

try {
    // CORRECCIÓN: Usamos las columnas reales de tu archivo SQL
    $sql = "SELECT t.*, p.permisionario_nombre 
            FROM taxi t 
            INNER JOIN permisionario p ON t.permisionario_id = p.permisionario_id 
            ORDER BY t.taxi_numero_economico ASC";
    
    // Ejecutamos la consulta usando tu objeto $pdo de conexion.php
    $stmt = $pdo->query($sql);
    
    // Guardamos todos los registros en la variable que espera recibir vistas/taxis.php
    $lista_taxis = $stmt->fetchAll();

} catch (\PDOException $e) {
    // En producción es mejor guardar el error en un log, pero para la escuela esto te ayuda a debuguear
    echo "Error al consultar la flota: " . $e->getMessage();
    $lista_taxis = []; // Evita que el foreach del HTML truene si la consulta falla
}
?>