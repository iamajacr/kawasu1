<?php
session_start();
// Si no hay sesión, salir
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php?vista=login");
    exit();
}

require_once "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM taxi WHERE taxi_id = :id");
        $stmt->execute([':id' => $id]);
        
        // Redirigir siempre a la lista tras borrar
        header("Location: ../index.php?vista=lista_taxis&status=eliminado");
        exit();
    } catch (PDOException $e) {
        // Si hay error, mostrarlo en lugar de pantalla en blanco
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php?vista=lista_taxis");
    exit();
}