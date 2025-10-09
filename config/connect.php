<?php
require 'config.php';

$conexion = new mysqli($server, $db_user, $db_password, $db_name) or 
die("Error en la conexion a la base de datos");
?>
