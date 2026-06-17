<?php
// 1. Conexión
require_once "./php/conexion.php"; 

// 2. Seguridad
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit();
}

// 3. Lógica de búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$sql = "SELECT * FROM taxi";

if (!empty($busqueda)) {
    // Buscamos por numero_economico (ahora llamado 'Número de Radio') o placas
    $sql .= " WHERE taxi_numero_economico LIKE :busqueda OR taxi_placa LIKE :busqueda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':busqueda' => "%$busqueda%"]);
} else {
    $stmt = $pdo->query($sql);
}
?>

<form action="index.php" method="GET">
    <input type="hidden" name="vista" value="lista_taxis">
    <input type="text" name="busqueda" placeholder="Buscar por N° de Radio o placas..." value="<?php echo htmlspecialchars($busqueda); ?>">
    <button type="submit">Filtrar</button>
</form>

<table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background-color: #4caf50; color: white;">
            <th>N° de Radio</th> <th>Placas</th>
            <th>Estado Pago</th> 
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($stmt->rowCount() > 0) {
            while ($t = $stmt->fetch()) { 
                $estado = isset($t['pago_estado']) ? $t['pago_estado'] : 0;
                $link_estado = ($estado == 1 ? 0 : 1);
                $texto_estado = ($estado == 1 ? "✅ Pagado" : "❌ Pendiente");
        ?>
        <tr>
            <td><?php echo htmlspecialchars($t['taxi_numero_economico']); ?></td>
            <td><?php echo htmlspecialchars($t['taxi_placa']); ?></td>
            <td>
                <a href="php/actualizar_pago.php?id=<?php echo $t['taxi_id']; ?>&estado=<?php echo $link_estado; ?>">
                    <?php echo $texto_estado; ?>
                </a>
            </td>
            <td>
                <a href="php/eliminar_taxi.php?id=<?php echo $t['taxi_id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar?');">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php 
            } 
        } else {
            echo "<tr><td colspan='4' style='text-align: center;'>No se encontraron resultados.</td></tr>";
        }
        ?>
    </tbody>
</table>