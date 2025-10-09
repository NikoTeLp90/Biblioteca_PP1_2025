<?php
include '../../sql/db_functions.php';

// Verificar que se recibió el ID por POST
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Llamar a la función de eliminar
    eliminarAlumno($conexion, $id);
    header("Location: listar_alumnos.php");
    exit();
} else {
    echo "Error: No se proporcionó un ID válido";
}
?>
