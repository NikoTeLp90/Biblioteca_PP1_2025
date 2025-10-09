<?php
include '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    eliminarInsumo($conexion, $id);
    header("Location: listar_insumo.php"); // El  ---header---   me redirije
    exit();
}
?>