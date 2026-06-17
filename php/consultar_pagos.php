<?php
// php/consultar_pagos.php
include_once "conexion.php";

try {
    // Cruzamos la tabla real pago_estatus con taxi y permisionario
    $sql = "SELECT pe.año_fiscal, pe.pago_referendo, pe.pago_impuestos, 
                   t.taxi_numero_economico, t.taxi_placa, p.permisionario_nombre 
            FROM pago_estatus pe
            INNER JOIN taxi t ON pe.taxi_id = t.taxi_id
            INNER JOIN permisionario p ON t.permisionario_id = p.permisionario_id
            ORDER BY pe.año_fiscal DESC, t.taxi_numero_economico ASC";
    
    $stmt = $pdo->query($sql);
    $lista_pagos = $stmt->fetchAll();

} catch (\PDOException $e) {
    echo "Error al consultar estatus financieros: " . $e->getMessage();
    $lista_pagos = [];
}
?>