<?php
session_start();

include '../../sql/db_functions.php';

// IMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $codigo = trim($_POST["codigo"]);
    $categoria = trim($_POST["categoria"]);
    $carrera = trim($_POST["carrera"]);
    $estado = trim($_POST["estado"]);
    $observaciones = trim($_POST["observaciones"]);

    
    crearInsumo($conexion, $codigo, $nombre, $categoria, $carrera, $estado, $observaciones);
    header("Location: listar_insumo.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear insumo</title>
</head>

<body>
    <h1>Crear insumo</h1>
    
    <form action="agregar_insumo.php" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
        <br>

        <label for="codigo">codigo:</label>
        <input type="text" name="codigo" placeholder="Ingrese un codigo" required>
        <br>

        <label for="categoria">categoria:</label>
        <select name="categoria">
            <option value="tecnologia">Tecnologia</option>
            <option value="bibliografia">Bibliografia</option>
            <option value="electrico">Electrico</option>
            <option value="Otro">Otro</option>
        </select>

        <label for="carrera">carrera:</label>
        <select name="carrera">
            <option value="analisis_de_sistemas">Analisis de Sistemas</option>
            <option value="Seguridad_E_Higiene">Seguridad_E_Higiene</option>
            <option value="Internet_de_las_Cosas">Internet_de_las_Cosas</option>
            <option value="Otro">Otro</option>
        </select>

        <label for="estado">estado:</label>
        <select name="estado">
            <option value="disponible"> Disponible</option>
            <option value="En_reparacion"> En reparacion</option>
            <option value="fuera_de_servicio"> fuera_de_servicio</option>
        </select>

        <label for="observaciones">observaciones:</label>
        <input type="text" name="observaciones" required><br>


        <input type="submit" value="Guardar">
        <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
    </form>

</body>
</html>