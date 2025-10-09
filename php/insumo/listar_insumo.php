<?php
session_start();

include '../../sql/db_functions.php';

// IMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$insumos = obtenerInsumos($conexion); 
?>

<html>
<head>
    <title>Lista de insumos</title>
</head>
<body>
    <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>

    <table border="2">
        <tr>
            <th>ID Insumo</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Categoría</th>
            <th>Carrera</th>
            <th>Estado</th>
            <th>Observación</th>
            <th>Acciones</th>
        </tr>

        <tbody>
            <?php
           if($insumos->num_rows > 0){
                foreach ($insumos as $insumo) {
                    echo '<tr>';
                    echo '<td>' . $insumo['id'] . '</td>';
                    echo '<td>' . $insumo['nombre'] . '</td>';
                    echo '<td>' . $insumo['codigo'] . '</td>';
                    echo '<td>' . $insumo['categoria'] . '</td>';
                    echo '<td>' . $insumo['carrera'] . '</td>';
                    echo '<td>' . $insumo['estado'] . '</td>';
                    echo '<td>' . $insumo['observaciones'] . '</td>';
                    echo '<td>
                            <a href="actualizar_insumo.php?id=' . $insumo['id'] . '">Editar</a>
                            <form action="eliminar_insumo.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="' . $insumo['id'] . '">
                                <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este insumo?\')">Eliminar</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="8"><h3>No hay insumos registrados</h3></td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>