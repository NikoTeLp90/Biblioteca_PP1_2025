<?php

include '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$id = $_GET['id'];

$alumno = obtenerAlumno($conexion, $id);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $email = trim($_POST["email"]);
    $cargo = trim($_POST["cargo"]);

    actualizarAlumno($conexion, $id, $nombre, $apellido, $email, $cargo);
    header("Location: listar_alumnos.php");
    exit();
}

?>

<html>

<head>
    <title>Actualizar alumno</title>
</head>

<body>
    <h1>Actualizar alumno</h1>
    <form action="../../php/alumno/actualizar_alumno.php?id=<?php echo $id; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required value="<?php echo $alumno['nombre']; ?>">
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required value="<?php echo $alumno['apellido']; ?>">
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" required value="<?php echo $alumno['email']; ?>"><br>

        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" required value="<?php echo $alumno['cargo']; ?>"><br>

        <input type="submit" value="Actualizar">
        <button type="button" onclick="window.location.href='../../index.html'">Ir al Index</button>
    </form>
</body>

</html>