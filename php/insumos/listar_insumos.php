<?php
include '../sql/db_functions.php';

$insumos = obtenerInsumos($conexion); // función con mayúscula consistente
?>

<html>
<head>
    <title>Lista de insumos</title>
</head>
<body>
    <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>

    <table border="2">
        <tr>
            <th>ID Insumo</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Categoría</th>
            <th>Materia</th>
            <th>Estado</th>
            <th>Observación</th>
            <th>Acciones</th>
        </tr>

        <tbody>
            <?php
            if (count($insumos) > 0) {
                foreach ($insumos as $insumo) {
                    echo '<tr>';
                    echo '<td>' . $insumo['id_insumo'] . '</td>';
                    echo '<td>' . $insumo['nombre'] . '</td>';
                    echo '<td>' . $insumo['codigo'] . '</td>';
                    echo '<td>' . $insumo['categoria'] . '</td>';
                    echo '<td>' . $insumo['materia'] . '</td>';
                    echo '<td>' . $insumo['estado'] . '</td>';
                    echo '<td>' . $insumo['observacion'] . '</td>';
                    echo '<td>
                            <a href="../php/insumos/editar_insumo.php?id=' . $insumo['id_insumo'] . '">Editar</a>
                            <form action="../php/insumos/eliminar_insumo.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_insumo" value="' . $insumo['id_insumo'] . '">
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
