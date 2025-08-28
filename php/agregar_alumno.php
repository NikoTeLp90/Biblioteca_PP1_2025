<?php

include '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $dni = trim ($_POST["dni"]);

    crearAlumno($conexion, $nombre, $apellido, $dni);
}


?>

<html>
<head>
    <title>Crear alumno</title>
</head>

<body>
    <h1>Crear alumno</h1>

    <form action="../php/agregar_alumno.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
        <br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br>

        <input type="submit" value="Guardar">
        <button type="button" >Ir al Index</button>
    </form>

</body>
</html>