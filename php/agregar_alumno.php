<?php

include '../sql/db_functions.php';

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
  
  <form action="../php/agregar_alumno.php" method="post">

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
    <br>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
    <br>

    <label for="email">Mail:</label>
    <input type="text" name="email" placeholder="Ingrese un mail" required><br>

    <label for="cargo">Cargo:</label>
    <select name="cargo">
      <option value="bibliotecario">Bibliotecario</option>
      <option value="admin">Administrador</option>
      <option value="secretario">Secretario</option>
    </select>
      <br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" placeholder="Ingrese contraseña" required>
    <br>

    <input type="submit" value="Guardar">
  </form>

</body>
</html>
