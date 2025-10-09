<?php
include'../sql/db_functions.php';


if (isset($_GET['id'])) {
   $usuario_id= $_GET['id'];
   $query ="SELECT nombre, apellido, email, cargo, contrasenia FROM usuario WHERE id=?";

   If ($Stmt = $conexion->prepapre($query)) {
       $stmt->bind_param("i", $usuario_id);
       $stmt->execute();
       $stmt->bind_result($nombre, $apellido, $email, $cargo, $contrasenia);
       $stmt->fetch();
       $stmt->close();
   }
}else{
    echo "no se ha recibido el id del usuario";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crear alumno</h1>

    <form action="../php/prueba.php" method="post">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" placeholder="Ingrese un nombre" requierd>
          <br>

          <label for="apellido">Apellido:</label>
          <input type="text" name="apellido" placeholder="ingrese un apellido" requierd>
          <br>

          <label for="email">email:</label>
          <input type="text"name="email" requierd>
          <br>

          <label for="cargo">cargo:</label>
          <input type="text"name="cargo" requierd>
          <br>

          <label for="contrasenia">contrasenia:</label>
          <input type="password"name="contrasenia" requierd>
          <br>

          <input type="submit" value="Guardar">
          <button type="button" onclick="window.location.href='../index.html';">Ir al index</button>
    </form>
    
</body>
</html>