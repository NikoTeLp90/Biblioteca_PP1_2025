<?php
session_start();
include __DIR__ . '/../../sql/db_functions.php';


// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$id = $_GET['id'];
$insumo = obtenerInsumo($conexion, $id);

$nombre = $insumo['nombre'] ?? '';
$codigo = $insumo['codigo'] ?? '';
$categoria = $insumo['categoria'] ?? '';
$carrera = $insumo['carrera'] ?? '';
$estado = $insumo['estado'] ?? '';
$observaciones = $insumo['observaciones'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = trim($_POST["nombre"]);
    $codigo = trim($_POST["codigo"]);
    $categoria = trim($_POST["categoria"]);
    $carrera = trim($_POST["carrera"]);
    $estado = trim($_POST["estado"]);
    $observaciones = trim($_POST["observaciones"]);

    actualizarInsumo($conexion, $id, $nombre, $codigo, $categoria, $carrera, $estado, $observaciones);
    header("Location: listar_insumo.php");
    exit();
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

    <label for="carrera">carrera:</label>
    <select name="carrera">
        <option value="analisis_de_sistemas" <?php if($carrera=='analisis_de_sistemas') echo 'selected'; ?>>Análisis de Sistemas</option>
        <option value="seguridad_e_higiene" <?php if($carrera=='seguridad_e_higiene') echo 'selected'; ?>>Seguridad e Higiene</option>
        <option value="internet_de_las_cosas" <?php if($carrera=='internet_de_las_cosas') echo 'selected'; ?>>Internet de las Cosas</option>
        <option value="otro" <?php if($carrera=='otro') echo 'selected'; ?>>Otro</option>
    </select>
    <br>

    <label for="estado">Estado:</label>
    <select name="estado">
        <option value="disponible" <?php if($estado=='disponible') echo 'selected'; ?>>Disponible</option>
        <option value="en_reparacion" <?php if($estado=='en_reparacion') echo 'selected'; ?>>En reparación</option>
        <option value="fuera_de_servicio" <?php if($estado=='fuera_de_servicio') echo 'selected'; ?>>Fuera de servicio</option>
    </select>
    <br>

    <label for="observaciones">Observación:</label>
    <input type="text" name="observaciones" value="<?php echo htmlspecialchars($observaciones); ?>" required><br>

    
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="submit" value="Guardar">
    <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>
</form>