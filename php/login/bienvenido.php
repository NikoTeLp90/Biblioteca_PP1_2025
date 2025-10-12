<?php
session_start();

include '../../sql/db_functions.php';

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: login/login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

?>

<html>
    <head>
        <title>Bienvenido al sistema</title>
    </head>
    <body>
        <h1>Bienvenido <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <p><strong>Cargo:</strong> <?php echo htmlspecialchars($usuario['cargo']); ?></p>
        
        <br>
        <a href="alumno/listar_alumnos.php">Ver Lista de Usuarios</a><br>
        <a href="alumno/agregar_alumno.php">Agregar Usuario</a><br>
        <br>
        <a href="insumo/listar_insumo.php">Ver Lista de Insumos</a><br>
        <a href="insumo/agregar_insumo.php">Agregar Insumo</a><br>
        <br>
        <a href="login/login.php">Cerrar Sesión</a>
    </body>
</html>