<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

$usuarios = obtenerUsuarios($conexion);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Lista usuarios</title>
    </head>
    <body>

    <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>
    <br><br>

    <table border="2">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Mail</th>
            <th>Cargo</th>
            <th>Acciones</th>
        </tr>
    <tbody>

        <?php
        if (count($usuarios) > 0) {
            foreach ($usuarios as $usuario):
                echo '<tr>';
                echo '<td>' . $usuario['id'] . '</td>';
                echo '<td>' . $usuario['nombre'] . '</td>';
                echo '<td>' . $usuario['apellido'] . '</td>';
                echo '<td>' . $usuario['email'] . '</td>';
                echo '<td>' . $usuario['cargo'] . '</td>';
                echo '<td>
                        <a href="editar_usuario.php?id=' . $usuario['id'] . '">Editar</a>
                        <form action="eliminar_usuario.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="' . $usuario['id'] . '">
                        <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\')">Eliminar</button>
                        </form>
                    </td>';
                echo '</tr>';
            endforeach;
        } else {
            echo '<h1>No hay usuarios registrados</h1>';
        }

        ?>
    </table>
    </body>
</html>
