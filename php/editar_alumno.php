<?php
include '../sql/db_functions.php';


if (isset($_GET['id'])) {
    $alumno_id = $_GET['id'];

    $query = "SELECT nombre, apellido, dni FROM alumnos WHERE id = ?";
    if ($stmt = $conexion->prepare($query)) {

        $stmt->bind_param("i", $alumno_id);
        $stmt->execute();
        $stmt->bind_result($nombre, $apellido, $dni);
        $stmt->fetch();
        $stmt->close();
    }
} else {
    echo "No se ha recibido el ID del alumno.";
    exit;
}
?>

<form action="" method="post">
    <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br>
    <label>Apellido:</label>
    <input type="text" name="apellido" value="<?php echo $apellido; ?>"><br>
    <label>DNI:</label>
    <input type="text" name="dni" value="<?php echo $dni; ?>"><br>
    <button type="submit">Guardar cambios</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alumno_id = $_POST['alumno_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];;

    
    editarAlumno($conexion, $alumno_id, $nombre, $apellido, $dni);
}
?>