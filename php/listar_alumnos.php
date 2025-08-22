<?php
include '../sql/db_functions.php';

$alumnos = obtenerAlumnos($conexion);
?>

<html>
    <head>
        <title> Lista alumnos </title>
    </head>
    <body>
    <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
        <table border="2">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Acciones</th>
            </tr>
    <tbody>
        
        <?php
        if (count($alumnos) > 0) {
            foreach ($alumnos as $alumno):
                echo '<tr>';
                echo '<td>' . $alumno['id'] . '</td>';
                echo '<td>' . $alumno['nombre'] . '</td>';
                echo '<td>' . $alumno['apellido'] . '</td>';
                echo '<td>' . $alumno['dni'] . '</td>';
                echo '<td>
                        <a href="../php/editar_alumno.php?id=' . $alumno['id'] . '">Editar</a>
                        <form action="../php/eliminar_alumno.php" method="POST" style="display:inline;">
                            <input type="hidden" name="alumno_id" value="' . $alumno['id'] . '">
                            <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este alumno?\')">Eliminar</button>
                        </form>
                    </td>';
                echo '</tr>';
            endforeach;
        } else {
            echo '<h1>No hay alumnos registrados</h1>';
        }

        ?>
    </table>
    </tbody>
    </body>
</html>


