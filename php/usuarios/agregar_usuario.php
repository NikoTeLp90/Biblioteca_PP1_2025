<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $email = trim($_POST["email"]);
    $cargo = trim($_POST["cargo"]);
    $contrasena = trim($_POST["contrasena"]);
    $repetir_contrasena = trim($_POST["repetir_contrasena"]);

    if ($contrasena !== $repetir_contrasena) {
        header("Location: agregar_usuario.php?error=contrasena");
        exit();
    }

    $contrasena_hasheada = password_hash($contrasena, PASSWORD_DEFAULT);
    // PASSWORD_DEFAULT es una constante de PHP que indica que se debe usar
    // el algoritmo de hash mas seguro actualmente

    crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena_hasheada);
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

  <?php
    if (isset($_GET['error']) && $_GET['error'] == 'contrasena') {
        echo '<p>Error: Las contraseñas no coincidieron.</p>';
    }
  ?>

  <form action="agregar_usuario.php" method="post">

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
    <br><br>

    <label for="apellido">Apellido:</label><br>
    <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
    <br><br>

    <label for="email">Mail:</label><br>
    <input type="text" name="email" placeholder="Ingrese un mail" required>
    <br><br>

    <label for="cargo">Cargo:</label><br>
    <select name="cargo">
      <option value="bibliotecario">Bibliotecario</option>
      <option value="admin">Administrador</option>
      <option value="secretario">Secretario</option>
    </select>
    <br><br>

    <label for="contrasena">Contraseña:</label><br>
    <input type="password" name="contrasena" placeholder="Ingrese contraseña" required>
    <br><br>

    <label for="repetir_contrasena">Repetir contraseña:</label><br>
    <input type="password" name="repetir_contrasena" placeholder="Ingrese contraseña" required>
    <br><br>

    <input type="submit" value="Guardar">
  </form>

</body>
</html>
