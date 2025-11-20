<?php
require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Actualizar estado a inactivo (devuelto)
    $query = "UPDATE prestamo SET activo = 0 WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: listar_prestamos.php?mensaje=Préstamo devuelto correctamente&tipo=success");
        } else {
            // Redirigir con mensaje de error
            header("Location: listar_prestamos.php?mensaje=Error al devolver el préstamo&tipo=danger");
        }
        $stmt->close();
    } else {
        header("Location: listar_prestamos.php?mensaje=Error de base de datos&tipo=danger");
    }
} else {
    header("Location: listar_prestamos.php");
}
exit();
?>
