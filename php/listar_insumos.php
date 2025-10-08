<?php

require '../config/connect.php';
require '../sql/db_functions.php';

$insumos = obtenerInsumos($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Lista insumos</title>
    </head>
    <body>

    <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
    <br><br>

    <table border="2">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Disponibilidad</th>
            <th>Estado</th>
            <th>Observaciones</th>
        </tr>
    <tbody>

        <?php
        if (count($insumos) > 0) {
            foreach ($insumos as $insumo):
                echo '<tr>';
                echo '<td>' . $insumo['id'] . '</td>';
                echo '<td>' . $insumo['nombre'] . '</td>';
                echo '<td>' . $insumo['categoria'] . '</td>';
                echo '<td>' . $insumo['disponibilidad'] . '</td>';
                echo '<td>' . $insumo['estado'] . '</td>';
                echo '<td>' . $insumo['observaciones'] . '</td>';
                echo '<td>
                        <a href="../php/editar_insumo.php?id=' . $insumo['id'] . '">Editar</a>
                        <form action="../php/eliminar_insumo.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="' . $insumo['id'] . '">
                        <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este insumo?\')">Eliminar</button>
                        </form>
                    </td>';
                echo '</tr>';
            endforeach;
        } else {
            echo '<h1>No hay insumos registrados</h1>';
        }

        ?>
    </table>
    </body>
</html>