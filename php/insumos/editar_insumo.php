<?php
include '../sql/db_functions.php';


if (isset($_GET['id_insumo'])) {
    $id_insumo = $_GET['id_insumo'];

    $query = "SELECT nombre, codigo, categoria, materia, estado, observacion FROM insumo WHERE id_insumo = ?";
    if ($stmt = $conexion->prepare($query)) {

        $stmt->bind_param("i", $id_insumo);
        $stmt->execute();
        $stmt->bind_result($nombre, $codigo, $categoria, $materia, $estado, $observacion);
        $stmt->fetch();
        $stmt->close();
    }
} else {
    echo "No se ha recibido el ID del insumo.";
    exit;
}
?>

<form action="" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
    <br>

    <label for="codigo">Código:</label>
    <input type="text" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>" required>
    <br>

    <label for="categoria">Categoría:</label>
    <select name="categoria">
        <option value="tecnologia" <?php if($categoria=='tecnologia') echo 'selected'; ?>>Tecnología</option>
        <option value="bibliografia" <?php if($categoria=='bibliografia') echo 'selected'; ?>>Bibliografía</option>
        <option value="electrico" <?php if($categoria=='electrico') echo 'selected'; ?>>Eléctrico</option>
        <option value="otro" <?php if($categoria=='otro') echo 'selected'; ?>>Otro</option>
    </select>
    <br>

    <label for="materia">Materia:</label>
    <select name="materia">
        <option value="analisis_de_sistemas" <?php if($materia=='analisis_de_sistemas') echo 'selected'; ?>>Análisis de Sistemas</option>
        <option value="seguridad_e_higiene" <?php if($materia=='seguridad_e_higiene') echo 'selected'; ?>>Seguridad e Higiene</option>
        <option value="internet_de_las_cosas" <?php if($materia=='internet_de_las_cosas') echo 'selected'; ?>>Internet de las Cosas</option>
        <option value="otro" <?php if($materia=='otro') echo 'selected'; ?>>Otro</option>
    </select>
    <br>

    <label for="estado">Estado:</label>
    <select name="estado">
        <option value="disponible" <?php if($estado=='disponible') echo 'selected'; ?>>Disponible</option>
        <option value="en_reparacion" <?php if($estado=='en_reparacion') echo 'selected'; ?>>En reparación</option>
        <option value="fuera_de_servicio" <?php if($estado=='fuera_de_servicio') echo 'selected'; ?>>Fuera de servicio</option>
    </select>
    <br>

    <label for="observacion">Observación:</label>
    <input type="text" name="observacion" value="<?php echo htmlspecialchars($observacion); ?>" required><br>

    
    <input type="hidden" name="id_insumo" value="<?php echo $id_insumo; ?>">

    <input type="submit" value="Guardar">
    <a href="../index.html">Volver al index</a>
    <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
</form>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_insumo = $_POST['id_insumo'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $categoria = $_POST['categoria'];
    $materia = $_POST['materia'];
    $estado = $_POST['estado'];
    $observacion = $_POST['observacion'];

    
    editarInsumo($conexion, $id_insumo, $nombre, $codigo, $categoria, $materia, $estado, $observacion);
}
?>