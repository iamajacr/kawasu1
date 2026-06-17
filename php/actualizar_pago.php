<?php
require_once "conexion.php";
if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $nuevo_estado = $_GET['estado'];

    $stmt = $pdo->prepare("UPDATE taxi SET pago_estado = :estado WHERE taxi_id = :id");
    $stmt->execute([':estado' => $nuevo_estado, ':id' => $id]);

    header("Location: ../index.php?vista=lista_taxis");
}
?>