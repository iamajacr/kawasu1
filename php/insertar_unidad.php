<$php

include_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_economico = trim($_POST['numero_economico']);
    $placas           = trim($_POST['placas']);
    $modelo           = trim($_POST['modelo']);
    $chofer           = trim($_POST['chofer']);
    $estado           = "Activo"; // Por defecto entra operativa

    // Validar que los campos clave no estén vacíos
    if (empty($numero_economico) || empty($placas)) {
        header("Location: index.php?status=error_campos");
        exit();
    }

    try {
        
        $sql = "INSERT INTO unidades (numero_economico, placas, modelo, chofer, estado) 
                VALUES (:num_eco, :placas, :modelo, :chofer, :estado)";
        
        $stmt = $conexion->prepare($sql);

      
        $stmt->bindParam(':num_eco', $numero_economico);
        $stmt->bindParam(':placas', $placas);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':chofer', $chofer);
        $stmt->bindParam(':estado', $estado);

     
        if ($stmt->execute()) {
            // Si sale bien, redirige al panel con mensaje de éxito
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }
        exit();

    } catch (PDOException $e) {
        // Si hay error (ej. placa duplicada), redirige mostrando el fallo
        header("Location: index.php?status=error_db&msg=" . urlencode($e->getMessage()));
        exit();
    }
}
?>