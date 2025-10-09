<?php

include '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$alumnos = obtenerAlumnos($conexion);

?>

<html>
    <head>
        <title>Listado de alumnos</title>
    </head>
    <body>
        <h1>Listado de alumnos</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Acciones</th>
            </tr>
        <?php
        if($alumnos->num_rows > 0){
            foreach($alumnos as $alumno){
            echo "<tr>";
            echo "<td>" . $alumno['id'] . "</td>";
            echo "<td>" . $alumno['nombre'] . "</td>";
            echo "<td>" . $alumno['apellido'] . "</td>";
            echo "<td>" . $alumno['dni'] . "</td>";
            echo '<td>
                <form action="../../php/alumno/eliminar_alumno.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="' . $alumno['id'] . '">
                    <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar?\')">Eliminar</button>
                </form> |
                <button onclick="window.location.href=\'../../php/alumno/actualizar_alumno.php?id=' . $alumno['id'] . '\'">Actualizar</button>
            </td>';
            echo "</tr>";
        }
        }else{
            echo "<tr><td colspan='5'>No hay alumnos</td></tr>";
        }
        ?>
        </table>
    </body>
</html>