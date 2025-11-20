<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $insumo_id = (int)$_POST['id'];
    
    // Verificar que el insumo no esté en préstamo
    $stmt = $conexion->prepare("SELECT disponibilidad FROM insumo WHERE id = ?");
    $stmt->bind_param("i", $insumo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $insumo = $result->fetch_assoc();
    $stmt->close();

    if ($insumo && $insumo['disponibilidad'] === 'en_prestamo') {
        header("Location: listar_insumos.php?mensaje=" . urlencode("No se puede eliminar un insumo que está en préstamo") . "&tipo=danger");
        exit();
    }

    // Eliminar el insumo
    $sql = "DELETE FROM insumo WHERE id = ?";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $insumo_id);
        if ($stmt->execute()) {
            $mensaje = "Insumo eliminado correctamente";
            $tipo = "success";
        } else {
            $mensaje = "Error al eliminar el insumo";
            $tipo = "danger";
        }
        $stmt->close();
    } else {
        $mensaje = "Error al preparar la consulta";
        $tipo = "danger";
    }
    
    header("Location: listar_insumos.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
    exit();
} else {
    header("Location: listar_insumos.php");
    exit();
}
