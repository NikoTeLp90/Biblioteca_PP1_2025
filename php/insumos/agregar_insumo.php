<?php
// ✅ Siempre conviene usar __DIR__ para evitar errores de rutas
include __DIR__ . '/../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitización básica
    $nombre = trim($_POST["nombre"]);
    $codigo = trim($_POST["codigo"]);
    $categoria = trim($_POST["categoria"]);
    $materia = trim($_POST["materia"]);
    $estado = trim($_POST["estado"]);
    $observacion = trim($_POST["observacion"]);

    // ✅ Llamamos a la función solo si todos los campos están completos
    if ($nombre && $codigo && $categoria && $materia && $estado && $observacion) {
        crearInsumo($conexion, $nombre, $codigo, $categoria, $materia, $estado, $observacion);
        // Redirigimos después de crear
        header("Location: listar_insumo.php");
        exit();
    } else {
        echo "⚠️ Por favor, complete todos los campos.";
    }
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
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required><br>

        <label for="codigo">Código:</label>
        <input type="text" name="codigo" placeholder="Ingrese un código" required><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" required>
            <option value="tecnologia">Tecnología</option>
            <option value="bibliografia">Bibliografía</option>
            <option value="electrico">Eléctrico</option>
            <option value="otro">Otro</option>
        </select><br>

        <label for="materia">Materia:</label>
        <select name="materia" required>
            <option value="analisis_de_sistemas">Análisis de Sistemas</option>
            <option value="seguridad_e_higiene">Seguridad e Higiene</option>
            <option value="internet_de_las_cosas">Internet de las Cosas</option>
            <option value="otro">Otro</option>
        </select><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="disponible">Disponible</option>
            <option value="en_reparacion">En reparación</option>
            <option value="fuera_de_servicio">Fuera de servicio</option>
        </select><br>

        <label for="observacion">Observación:</label>
        <input type="text" name="observacion" placeholder="Ingrese una observación" required><br><br>

        <input type="submit" value="Guardar">
        <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>
    </form>
</body>
</html>
