<?php
require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$alumnos = obtenerUsuarios($conexion);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../src/css/styles.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../src/img/logo i12 fondo blanco.png" alt="Logo" class="d-inline-block align-text-top me-2"
            style="height: 40px" />
            Instituto Superior de Formación Técnica Nº 12
        </a>
        <!-- boton que dijo el profe para el navbar responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="../../index.html" id="linkInicio">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../php/insumos/listar_insumos.php" id="linkInsumos">Insumos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../prestamos/prestamos.html" id="linkPrestamos">Préstamos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../php/usuarios/listar_alumnos.php" id="linkUsuarios">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../php/login/logout.php" id="linkSalir">Salir</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container my-3 d-flex justify-content-end">
        <a href="../../php/usuarios/agregar_alumno.php" class="btn btn-danger">Alta Usuario</a>
    </div>

    <div class="container">
        <table class="table table-striped table-hover table-bordered" id="usuariosTable">
        <thead class="table-dark">
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Mail</th>
            <th scope="col">Cargo</th>
            <th scope="col">Acción</th>
            </tr>
        </thead>
    <tbody>
        <?php

        if (count($alumnos) > 0) {
            foreach ($alumnos as $alumno):
                echo '<tr>';
                echo '<td>' . $alumno['id'] . '</td>';
                echo '<td>' . $alumno['nombre'] . '</td>';
                echo '<td>' . $alumno['apellido'] . '</td>';
                echo '<td>' . $alumno['email'] . '</td>';
                echo '<td>' . $alumno['cargo'] . '</td>';
                echo '<td>
                        <a href="../usuarios/editar_alumno.php?id=' . $alumno['id'] . '">Editar</a>
                        <form action="../usuarios/eliminar_alumno.php" method="POST" style="display:inline;">
                            <input type="hidden" name="alumno_id" value="' . $alumno['id'] . '">
                            <button type="submit" onclick="return confirm(\'¿Esta seguro que desea eliminar? a el ' .$alumno['cargo'].' ' .$alumno['nombre'] . '\')">Eliminar</button>
                        </form>
                    </td>';
                echo '</tr>';
            endforeach;
        } else {
            echo '<td> No hay alumnos registrados </td>' ;
        }

        ?>
    </table>
    </tbody>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>


