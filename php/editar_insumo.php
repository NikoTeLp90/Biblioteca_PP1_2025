<?php

require '../config/connect.php';
require '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    editarInsumo($conexion, $_POST['id'], $_POST['nombre'], $_POST['categoria'], $_POST['disponibilidad'], $_POST['estado'], $_POST['observaciones']);

    header("Location: listar_insumos.php");
    exit();
}

$insumo_id = $_GET['id'];

$stmt = $conexion->prepare("SELECT nombre, categoria, disponibilidad, estado, observaciones FROM insumo WHERE id = ?");
$stmt->bind_param("i", $insumo_id);
$stmt->execute();
$stmt->bind_result($nombre, $categoria, $disponibilidad, $estado, $observaciones);
$stmt->fetch();
$stmt->close();
$conexion->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h3>Editando insumo: <?php echo $nombre ?></h3>

    <form action="editar_insumo.php" method="post">

      <input type="hidden" name="id" value="<?php echo $insumo_id; ?>">

      <label for="nombre">Nombre:</label><br>
      <input type="text" name="nombre" value="<?php echo $nombre; ?>" required >
      <br><br>

      <label for="categoria">Categoría:</label><br>
      <select name="categoria">
        <option value="tecnologia" <?php if($categoria == "tecnologia") echo 'selected'; ?> >Tecnologia</option>
        <option value="bibliografia" <?php if($categoria == "bibliografia") echo 'selected'; ?> >Bibliografía</option>
        <option value="electronica" <?php if($categoria == "electronica") echo 'selected'; ?> >Electronica</option>
        <option value="otros" <?php if($categoria == "otros") echo 'selected'; ?> >Otros</option>
      </select>
      <br><br>

      <label for="disponibilidad">Disponibilidad:</label><br>
      <select name="disponibilidad">
        <option value="disponible" <?php if($disponibilidad == "disponible") echo 'selected'; ?> >Disponible</option>
        <option value="en_prestamo" <?php if($disponibilidad == "en_prestamo") echo 'selected'; ?> >En préstamo</option>
        <option value="baja" <?php if($disponibilidad == "baja") echo 'selected'; ?> >Baja</option>
      </select>
      <br><br>

      <label for="estado">Estado:</label><br>
      <select name="estado">
        <option value="disponible" <?php if($estado == "disponible") echo 'selected'; ?> >Disponible</option>
        <option value="en_reparacion" <?php if($estado == "en_reparacion") echo 'selected'; ?> >En reparación</option>
        <option value="fuera_servicio" <?php if($estado == "fuera_servicio") echo 'selected'; ?> >Fuera de servicio</option>
      </select>
      <br><br>

      <label for="observaciones">Observaciones:</label><br>
      <input type="text" name="observaciones" value="<?php echo $observaciones; ?>" required >
      <br><br>

      <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>