<?php
include 'config.php';
$conexion = new mysqli($server, $db_user, $db_password, $db_name) or 
die("Error al conectar con la base de datos");
?>
