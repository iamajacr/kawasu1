<?php 
// vistas/pagos.php
include_once "php/consultar_pagos.php"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ecotaxis Verde - Control de Pagos</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 20px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #1e5631; border-bottom: 3px solid #4caf50; padding-bottom: 10px; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h3 { margin-top: 0; color: #1e5631; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #4caf50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        .btn:hover { background: #388e3c; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1e5631; color: white; }
        tr:hover { background: #f1f8e9; }
        .badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 0.85em; text-transform: uppercase; }
        .badge-pagado { background: #d4edda; color: #155724; }
        .badge-pendiente { background: #f8d7da; color: #721c24; }
        .alerta { padding: 10px; margin-bottom: 15px; border-radius: 4px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h1>💳 Control Financiero y Estatus de Pagos</h1>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success_pago'): ?>
            <div class="alerta success">¡Estatus de pago actualizado y registrado con éxito!</div>
        <?php elseif ($_GET['status'] == 'campos_vacios'): ?>
            <div class="alerta error">Por favor, rellena todos los campos del estatus.</div>
        <?php elseif ($_GET['status'] == 'error_db'): ?>
            <div class="alerta error">Error: <?php echo htmlspecialchars($_GET['msg'] ?? ''); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="grid">
        <div class="card">
            <h3>Actualizar Estatus Fiscal</h3>
            <form action="php/insertar_pago.php" method="POST">
                <div class="form-group">
                    <label>ID Interno del Taxi:</label>
                    <input type="number" name="taxi_id" placeholder="Ej. 1" required>
                </div>
                <div class="form-group">
                    <label>Año Fiscal:</label>
                    <input type="number" name="año_fiscal" value="<?php echo date('Y'); ?>" min="2000" max="2100" required>
                </div>
                <div class="form-group">
                    <label>Pago Referendo:</label>
                    <select name="pago_referendo" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pago Impuestos:</label>
                    <select name="pago_impuestos" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                    </select>
                </div>
                <button type="submit" class="btn">Guardar Estatus</button>
            </form>
        </div>

        <div class="card">
            <h3>Monitoreo de Estatus por Unidad</h3>
            <table>
                <thead>
                    <tr>
                        <th>No. Económico</th>
                        <th>Placa</th>
                        <th>Permisionario</th>
                        <th>Año Fiscal</th>
                        <th>Referendo</th>
                        <th>Impuestos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lista_pagos)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No hay registros de estados de pago en el sistema.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($lista_pagos as $pago): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($pago['taxi_numero_economico']); ?></strong></td>
                                <td><?php echo htmlspecialchars($pago['taxi_placa']); ?></td>
                                <td><?php echo htmlspecialchars($pago['permisionario_nombre']); ?></td>
                                <td style="text-align: center;"><?php echo htmlspecialchars($pago['año_fiscal']); ?></td>
                                <td>
                                    <?php $ref_pagado = ($pago['pago_referendo'] == 'Pagado'); ?>
                                    <span class="badge <?php echo $ref_pagado ? 'badge-pagado' : 'badge-pendiente'; ?>">
                                        <?php echo htmlspecialchars($pago['pago_referendo']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $imp_pagado = ($pago['pago_impuestos'] == 'Pagado'); ?>
                                    <span class="badge <?php echo $imp_pagado ? 'badge-pagado' : 'badge-pendiente'; ?>">
                                        <?php echo htmlspecialchars($pago['pago_impuestos']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>