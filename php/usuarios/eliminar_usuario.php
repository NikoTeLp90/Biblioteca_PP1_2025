<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['id'];
    eliminarUsuario($conexion, $usuario_id);
    header("Location: listar_usuarios.php"); // El  ---header---   me redirije
    exit();
}
?>
