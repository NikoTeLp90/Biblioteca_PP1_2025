<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insumo_id = $_POST['id'];
    eliminarInsumo($conexion, $insumo_id);
    header("Location: ../insumos/listar_insumos.php"); // El  ---header---   me redirije
    exit();
}
?>
