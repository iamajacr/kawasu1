<?php 
// Incluimos el script que va a traer los taxis de la Base de Datos
include_once "../consultar_taxis.php"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sindicato - Control de Ecotaxis Verde</title>
    <style>
        /* Estilos rápidos para que se vea ordenado y limpio en tu Arch/CachyOS */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 20px; color: #333; }
        .container { max-width: 1100px; margin: 0 auto; }
        h1 { color: #1e5631; border-bottom: 3px solid #4caf50; padding-bottom: 10px; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h3 { margin-top: 0; color: #1e5631; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #4caf50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        .btn:hover { background: #388e3c; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1e5631; color: white; }
        tr:hover { background: #f1f8e9; }
        .alerta { padding: 10px; margin-bottom: 15px; border-radius: 4px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h1>🚖 Sistema de Gestión - ECOTAXIS VERDE</h1>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alerta success">¡Unidad registrada correctamente en la flota!</div>
        <?php elseif ($_GET['status'] == 'campos_vacios'): ?>
            <div class="alerta error">Por favor, rellena todos los campos obligatorios.</div>
        <?php elseif ($_GET['status'] == 'error_db'): ?>
            <div class="alerta error">Error en la Base de Datos: <?php echo htmlspecialchars($_GET['msg'] ?? ''); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="grid">
        <div class="card">
            <h3>Registrar Nueva Unidad</h3>
            <form action="../insertar_taxi.php" method="POST">
                <div class="form-group">
                    <label>Número Económico:</label>
                    <input type="text" name="numero_economico" placeholder="Ej. 145" required>
                </div>
                <div class="form-group">
                    <label>Placas:</label>
                    <input type="text" name="placas" placeholder="Ej. VRD-45-12" required>
                </div>
                <div class="form-group">
                    <label>Modelo / Año:</label>
                    <input type="text" name="modelo" placeholder="Ej. Nissan Tsuru 2015">
                </div>
                <div class="form-group">
                    <label>Permisionario (Dueño):</label>
                    <input type="number" name="id_permisionario" placeholder="ID del dueño (Ej. 1)" required>
                </div>
                <button type="submit" class="btn">Guardar Taxi</button>
            </form>
        </div>

        <div class="card">
            <h3>Monitoreo de Unidades Activas</h3>
            <table>
                <thead>
                    <tr>
                        <th>No. Eco</th>
                        <th>Placas</th>
                        <th>Modelo</th>
                        <th>Permisionario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lista_taxis)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No hay taxis registrados en la base de datos.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($lista_taxis as $taxi): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($taxi['numero_economico']); ?></strong></td>
                                <td><?php echo htmlspecialchars($taxi['placas']); ?></td>
                                <td><?php echo htmlspecialchars($taxi['modelo']); ?></td>
                                <td><?php echo htmlspecialchars($taxi['nombre_permisionario'] ?? 'ID: ' . $taxi['id_permisionario']); ?></td>
                                <td style="color: green; font-weight: bold;"><?php echo htmlspecialchars($taxi['estado']); ?></td>
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