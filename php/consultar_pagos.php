<?php
// php/consultar_pagos.php
include_once "conexion.php";

try {
    // Cruzamos el estatus de pago con el taxi y el permisionario para tener la info completa
    $sql = "SELECT pe.*, t.taxi_numero_economico, t.taxi_placa, p.permisionario_nombre 
            FROM pago_estatus pe
            INNER JOIN taxi t ON pe.taxi_id = t.taxi_id
            INNER JOIN permisionario p ON t.permisionario_id = p.permisionario_id
            ORDER BY t.taxi_numero_economico ASC";
    
    $stmt = $pdo->query($sql);
    $lista_pagos = $stmt->fetchAll();

} catch (\PDOException $e) {
    echo "Error al consultar los estados de pago: " . $e->getMessage();
    $lista_pagos = [];
}
?>