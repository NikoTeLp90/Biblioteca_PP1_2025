<?php

include '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $email = trim($_POST["email"]);
    $cargo = trim($_POST["cargo"]);
    $contrasenia = trim($_POST["contrasenia"]);
    //tuve problemas al hashear porque tiene muchos caracteres el hash de la contraseña
    $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

    crearAlumno($conexion, $nombre, $apellido, $email, $cargo, $contrasenia);
    header("Location: listar_alumnos.php");
    exit();
}


?>

<html>
<head>
    <title>Crear alumno</title>
</head>

<body>
    <h1>Crear alumno</h1>

    <form action="agregar_alumno.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Ingrese un email" required>
        <br>

        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" placeholder="Ingrese un cargo" required>
        <br>

        <label for="contrasenia">Contraseña:</label>
        <input type="password" name="contrasenia" placeholder="Ingrese una contraseña" required>
        <br>

        <input type="submit" value="Guardar">
        <button type="button" onclick="window.location.href='../../index.html'">Ir al Index</button>
    </form>

</body>
</html>