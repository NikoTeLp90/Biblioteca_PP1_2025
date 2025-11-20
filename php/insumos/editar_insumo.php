<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $nombre = trim($_POST['nombre']);
    $estado = trim($_POST['estado']);
    $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';

    // Obtener datos actuales del insumo para mantener categoria y disponibilidad
    $stmt = $conexion->prepare("SELECT categoria, disponibilidad FROM insumo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $insumo_actual = $result->fetch_assoc();
    $stmt->close();

    if ($insumo_actual) {
        // Mantener categoria y disponibilidad, solo actualizar nombre, estado y observaciones
        $categoria = $insumo_actual['categoria'];
        $disponibilidad = $insumo_actual['disponibilidad'];

        if (editarInsumo($conexion, $id, $nombre, $categoria, $disponibilidad, $estado, $observaciones)) {
            $mensaje = "Insumo actualizado correctamente";
            $tipo = "success";
        } else {
            $mensaje = "Error al actualizar el insumo";
            $tipo = "danger";
        }
    } else {
        $mensaje = "Insumo no encontrado";
        $tipo = "danger";
    }

    header("Location: listar_insumos.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
    exit();
} else {
    header("Location: listar_insumos.php");
    exit();
}
