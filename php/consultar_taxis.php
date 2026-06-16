<?php
// consultar_taxis.php
// Incluimos tu conexión hecha a mano
include_once "conexion.php";

try {
    // Cruzamos la tabla taxi con permisionario para traer el nombre del dueño
    // NOTA: Revisa que las columnas (id_permisionario, nombre, etc.) coincidan con tu BD
    $sql = "SELECT t.*, p.nombre AS nombre_permisionario 
            FROM taxi t 
            INNER JOIN permisionario p ON t.id_permisionario = p.id_permisionario 
            ORDER BY t.numero_economico ASC";
    
    // Ejecutamos la consulta directa usando tu objeto $pdo
    $stmt = $pdo->query($sql);
    
    // Guardamos todos los registros en una variable tipo array
    $lista_taxis = $stmt->fetchAll();

} catch (\PDOException $e) {
    echo "Error al consultar la flota: " . $e->getMessage();
    $lista_taxis = []; // Lo dejamos vacío si truena para que no rompa el HTML
}
?>