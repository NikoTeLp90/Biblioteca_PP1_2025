<?php
include '../sql/db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_insumo = $_POST['id_insumo'];
    eliminarInsumo($conexion, $id_insumo);
    header("Location: ../php/insumo/listar_insumo.php"); // El  ---header---   me redirije
    exit();
}
?>