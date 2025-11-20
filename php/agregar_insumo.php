<?php

require '../config/connect.php';
require '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $categoria = trim($_POST["categoria"]);
    $disponibilidad = trim($_POST["disponibilidad"]);
    $estado = trim($_POST["estado"]);
    $observaciones = trim($_POST["observaciones"]);

    // agregarInsumo($conexion, $codigo, $nombre, $categoria, $disponibilidad, $estado, $observaciones);
    agregarInsumo($conexion, $nombre, $categoria, $disponibilidad, $estado, $observaciones);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Insumo</title>
</head>

<body>

  <h1>Agregar insumo</h1>

  <form action="../php/agregar_insumo.php" method="post">

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" placeholder="Ingrese nombre insumo" required>
    <br><br>

    <label for="categoria">Categoría:</label><br>
    <select name="categoria">
      <option value="tecnologia">Tecnologia</option>
      <option value="bibliografia">Bibliografía</option>
      <option value="electronica">Electronica</option>
      <option value="otros">Otros</option>
    </select>
    <br><br>

    <label for="disponibilidad">Disponibilidad:</label><br>
    <select name="disponibilidad">
      <option value="disponible">Disponible</option>
      <option value="en_prestamo">En préstamo</option>
      <option value="baja">Baja</option>
    </select>
    <br><br>

    <label for="estado">Estado:</label><br>
    <select name="estado">
      <option value="disponible">Disponible</option>
      <option value="en_reparacion">En reparación</option>
      <option value="fuera_servicio">Fuera de servicio</option>
    </select>
    <br><br>

    <label for="observaciones">Observaciones:</label><br>
    <input type="text" name="observaciones" placeholder="Observaciones" required>
    <br><br>

    <input type="submit" value="Guardar">
  </form>

</body>
</html>
