<?php

include '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $email = trim($_POST["email"]);
    $cargo = trim($_POST["cargo"]);
    $contrasena = trim($_POST["contrasena"]);

    
    crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>
    <h1>Crear usuario</h1>
    
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
        <br>

        <label for="email">Email:</label>
        <input type="text" name="email" required><br>

        <label for="cargo">Cargo:</label>
        <select name="cargo" required>
            <option value="bibliotecario">Bibliotecario</option>
            <option value="admin">Administrador</option>
            <option value="secretario">Secretario</option>
        </select>
        <br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Guardar">

        <br><br>
        <a href="../../index.html">Volver al index</a>
        <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>
    </form>
</body>
</html>
