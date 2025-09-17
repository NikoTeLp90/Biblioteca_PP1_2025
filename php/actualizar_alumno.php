<?php

include '../sql/db_functions.php';

$id = $_GET['id'];

$alumno = obtenerAlumno($conexion, $id);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $dni = trim($_POST["dni"]);
    actualizarAlumno($conexion, $id, $nombre, $apellido, $dni);
    header("Location: ../php/listar_alumnos.php");
    exit();
}

?>

<html>

<head>
    <title>Actualizar alumno</title>
</head>

<body>
    <h1>Actualizar alumno</h1>
    <form action="../php/actualizar_alumno.php?id=<?php echo $id; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required value="<?php echo $alumno['nombre']; ?>">
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required value="<?php echo $alumno['apellido']; ?>">
        <br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required value="<?php echo $alumno['dni']; ?>"><br>

        <input type="submit" value="Actualizar">
        <button type="button" onclick="window.location.href='../index.html'">Ir al Index</button>
    </form>
</body>

</html>