<?php
// 1. Verificación de seguridad: Si no hay un ID de usuario en la sesión, el usuario no ha pasado por el login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit();
}

// 2. Incluir lógica de consulta
require_once "./php/conexion.php"; 

$consulta_taxis = $pdo->query("SELECT * FROM taxi"); 
?>

<div style="padding: 20px;">
    <h2>Lista de Taxis Registrados</h2>
    
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #4caf50; color: white;">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">No. Económico</th>
                <th style="padding: 10px;">Placas</th>
                <th style="padding: 10px;">Modelo</th>
                <th style="padding: 10px;">Año</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($consulta_taxis->rowCount() > 0) {
                while ($taxi = $consulta_taxis->fetch()) { 
                    echo "<tr>
                            <td style='padding: 10px;'>".$taxi['taxi_id']."</td>
                            <td style='padding: 10px;'>".$taxi['taxi_numero_economico']."</td>
                            <td style='padding: 10px;'>".$taxi['taxi_placa']."</td>
                            <td style='padding: 10px;'>".$taxi['taxi_modelo']."</td>
                            <td style='padding: 10px;'>".$taxi['taxi_año']."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='padding: 10px; text-align: center;'>No hay taxis registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>