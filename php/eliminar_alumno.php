<?php
include '../sql/db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno_id = $_POST['alumno_id'];
    eliminarAlumno($conexion, $alumno_id);
    header("Location: ../php/listar_alumnos.php"); // El  ---header---   me redirije
    exit();
}
?>