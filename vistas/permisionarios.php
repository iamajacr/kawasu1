<?php
// 1. Verificación de seguridad
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?vista=login");
    exit();
}

// 2. Incluir conexión y consultar permisionarios
require_once "./php/conexion.php";
$consulta_permisionarios = $pdo->query("SELECT * FROM permisionario");
?>

<div class="container">
    <h2>Gestión de Permisionarios</h2>
    
    <form action="php/insertar_permisionario.php" method="POST" class="card">
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>RFC:</label>
            <input type="text" name="rfc" required>
        </div>
        <div class="form-group">
            <label>Teléfono:</label>
            <input type="text" name="telefono">
        </div>
        <button type="submit" class="btn">Guardar Permisionario</button>
    </form>

    <hr>

    <h3>Lista de Permisionarios Registrados</h3>
    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
            <tr style="background-color: #1e5631; color: white;">
                <th style="padding: 10px;">Nombre</th>
                <th style="padding: 10px;">RFC</th>
                <th style="padding: 10px;">Teléfono</th>
                <th style="padding: 10px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($consulta_permisionarios->rowCount() > 0) {
                while ($p = $consulta_permisionarios->fetch()) { 
                    echo "<tr>
                            <td style='padding: 10px;'>".htmlspecialchars($p['permisionario_nombre'])."</td>
                            <td style='padding: 10px;'>".htmlspecialchars($p['permisionario_rfc'])."</td>
                            <td style='padding: 10px;'>".htmlspecialchars($p['permisionario_telefono'])."</td>
                            <td style='padding: 10px; text-align: center;'>
                                <a href='php/eliminar_permisionario.php?id=".$p['permisionario_id']."' 
                                   onclick=\"return confirm('¿Estás seguro de eliminar este permisionario?');\"
                                   style='color: red; font-weight: bold; text-decoration: none;'>
                                   🗑️ Eliminar
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='padding: 10px; text-align: center;'>No hay permisionarios registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="php/exportar_datos.php?tabla=permisionarios" class="btn" style="background: #2196f3; margin-top: 20px; display: inline-block; text-decoration: none; text-align: center;">
        📥 Descargar lista de Permisionarios (CSV)
    </a>
</div>