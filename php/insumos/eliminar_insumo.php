<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insumo_id = $_POST['id'];
    eliminarInsumo($conexion, $insumo_id);
    header("Location: ../php/listar_insumos.php"); // El  ---header---   me redirije
    exit();
}
?>
