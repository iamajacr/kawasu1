<?php
session_start();
if (!isset($_SESSION['usuario_id'])) exit("Acceso denegado");

require_once "conexion.php";

$tipo = $_GET['tabla']; // 'taxis' o 'permisionarios'
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="reporte_'.$tipo.'.csv"');

$output = fopen("php://output", "w");
fputcsv($output, array('ID', 'Nombre/Económico', 'Detalle', 'Registro')); // Encabezados

$query = ($tipo == 'taxis') ? "SELECT * FROM taxi" : "SELECT * FROM permisionario";
$datos = $pdo->query($query);

foreach($datos as $fila) {
    fputcsv($output, $fila);
}
fclose($output);