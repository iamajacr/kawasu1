<?php
// php/insertar_pago.php
session_start();
include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taxi_id        = trim($_POST['taxi_id'] ?? '');
    $año_fiscal     = trim($_POST['año_fiscal'] ?? '');
    $pago_referendo = trim($_POST['pago_referendo'] ?? 'Pendiente');
    $pago_impuestos = trim($_POST['pago_impuestos'] ?? 'Pendiente');

    if (empty($taxi_id) || empty($año_fiscal)) {
        header("Location: ../index.php?vista=pagos&status=campos_vacios");
        exit();
    }

    try {
        // Buscamos si ya existe el registro de ese taxi para ese año fiscal específico
        $queryCheck = "SELECT pago_id FROM pago_estatus WHERE taxi_id = :taxi_id AND año_fiscal = :anio";
        $stmtCheck = $pdo->prepare($queryCheck);
        $stmtCheck->execute([':taxi_id' => $taxi_id, ':anio' => $año_fiscal]);
        $existe = $stmtCheck->fetch();

        if ($existe) {
            // Si ya existe, actualizamos los estados del año fiscal correspondiente
            $sql = "UPDATE pago_estatus 
                    SET pago_referendo = :referendo, pago_impuestos = :impuestos 
                    WHERE taxi_id = :taxi_id AND año_fiscal = :anio";
        } else {
            // Si es nuevo, lo insertamos limpiamente
            $sql = "INSERT INTO pago_estatus (taxi_id, año_fiscal, pago_referendo, pago_impuestos) 
                    VALUES (:taxi_id, :anio, :referendo, :impuestos)";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':taxi_id'   => $taxi_id,
            ':anio'      => $año_fiscal,
            ':referendo' => $pago_referendo,
            ':impuestos' => $pago_impuestos
        ]);

        header("Location: ../index.php?vista=pagos&status=success_pago");
        exit();

    } catch (\PDOException $e) {
        header("Location: ../index.php?vista=pagos&status=error_db&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../index.php?vista=pagos");
    exit();
}
?>