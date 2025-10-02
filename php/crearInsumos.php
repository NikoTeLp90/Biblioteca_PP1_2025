<?php

include '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST["codigo"]);
    $nombre = trim($_POST["nombre"]);
    $categoria = trim($_POST["categoria"]);
    $estado = trim($_POST["estado"]);
    $observacion = trim($_POST["observacion"]);
    $disponibilidad = trim($_POST["disponibilidad"]);


    crearInsumo($conexion, $codigo, $nombre, $categoria, $estado, $observacion, $disponibilidad);
}

?>