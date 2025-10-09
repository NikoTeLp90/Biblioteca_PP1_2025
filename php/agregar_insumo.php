<?php

require '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST["codigo"]);
    $nombre = trim($_POST["nombre"]);
    $categoria = trim($_POST["categoria"]);
    $estado_conservacion = trim($_POST["estado_conservacion"]);
    $disponibilidad= trim($_POST["disponibilidad"]);
    $observacion= trim($_POST["observacion"]);

    agregarInsumo($conexion, $nombre, $categoria, $carrera, $estado_conservacion, $disponibilidad, $observacion);
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

  <h1>Agregar insumo</h1>

  <form action="../php/agregar_insumo.php" method="post">
    <label for="codigo">codigo:</label><br>
    <input type="text" codigo="codigo" placeholder="Ingrese un codigo" required>
    <br><br>
    
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
    <br><br>

    <label for="categoria">Categoria:</label><br>
    <select name="categoria">
      <option value="tecnologia">tecnologia</option>
      <option value="bibliografia">bibliografia</option>
      <option value="otros">otros</option>
    </select>
    <br><br>

      <label for="estado_conservacion">estado_conservacion:</label><br>
    <select name="estado_conservacion">
      <option value="correcto_estado">correcto_estado</option>
      <option value="fuera_servicio">fuera_servicio</option>
      <option value="repositorio">repositorio</option>
    </select>
    <br><br>

    <label for="gestion">gestion:</label><br>
    <select name="gestion">
      <option value="disponible">disponible</option>
      <option value="prestamo">prestamo</option>
      <option value="baja">baja</option>
    </select>
    <br><br>

    <label for="observacion">Observacion:</label><br>
    <input type="text" name="observacion" placeholder="Ingrese una observacion" required>
    <br><br>

    <input type="submit" value="Guardar">
  </form>

</body>
</html>