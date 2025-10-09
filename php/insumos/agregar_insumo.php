<?php

include '../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $codigo = trim($_POST["codigo"]);
    $categoria = trim($_POST["categoria"]);
    $materia = trim($_POST["materia"]);
    $estado = trim($_POST["estado"]);
    $observacion = trim($_POST["observacion"]);

    
    crearInsumo($conexion, $nombre, $codigo, $categoria, $materia, $estado, $observacion);
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
    
    <form action="" method="post">

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

        <label for="materia">materia:</label>
        <select name="materia">
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

        <label for="observacion">observacion:</label>
        <input type="text" name="observacion" required><br>


        <input type="submit" value="Guardar">
        <a href="../index.html">Volver al index</a>
        <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
    </form>

</body>
</html>
