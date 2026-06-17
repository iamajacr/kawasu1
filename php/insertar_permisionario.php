<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php?vista=login");
    exit();
}

require_once "conexion.php";

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM permisionario WHERE permisionario_id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        
        header("Location: ../index.php?vista=permisionarios&status=eliminado");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php?vista=permisionarios");
    exit();
}