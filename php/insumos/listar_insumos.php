<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$insumos = obtenerInsumos($conexion);
if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    echo json_encode($insumos);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Insumos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../src/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="insumos.js" defer></script>
    <!-- El atributo defer significa que el navegador descarga el script mientras carga el HTML, pero lo ejecuta recién cuando todo el HTML esté listo CONSULTAR -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../../src/img/logo i12 fondo blanco.png" alt="Logo" class="d-inline-block align-text-top me-2" style="height: 40px;">
                Instituto Superior de Formación Técnica Nº 12 
            </a>

            <!-- boton que dijo el profe para el navbar responsive --> 
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="../../index.php" id="linkInicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../../php/insumos/listar_insumos.php" id="linkInsumos">Insumos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../php/prestamo/listar_prestamos.php">Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../php/usuarios/listar_alumnos.php" id="linkUsuarios">Usuarios</a>
                    <li class="nav-item"><a class="nav-link" href="../../php/login/logout.php" id="linkSalir">Salir</a></li>
                    
                   
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2> INSUMOS - BIBLIOTECA I.S.F.T. N°12</h2>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="col-md-6">
                <input type="text" id="buscarInsumo" class="form-control" placeholder="Buscar insumo por nombre" oninput="filtrarInsumosPorNombre()">
            </div>
            <div>
                <a href="agregar_insumo.php" class="btn btn-danger"> Alta de Insumo</a>
            </div>
        </div>



        
        
<h1>Insumos Cargados </h1>
        <table class="table table-striped table-hover table-bordered" id="insumosTable">
            <thead class="table-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Observacion</th>
                    <th>Accion</th>
                </tr>

            </thead>
            <tbody>
<?php
        if (count($insumos) > 0) {
            foreach ($insumos as $insumo):
                echo '<tr>';
                echo '<td>' . $insumo['id'] . '</td>';
                echo '<td>' . $insumo['nombre'] . '</td>';
                echo '<td>' . $insumo['categoria'] . '</td>';
                echo '<td>' . $insumo['estado'] . '</td>';
                echo '<td>' . $insumo['observaciones'] . '</td>';
                echo '<td>
                        <a href="../insumos/editar_insumo.php?id=' . $insumo['id'] . '">Editar</a>
                        <form action="../insumos/eliminar_insumo.php" method="POST" style="display:inline;">
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

    <script>
        function filtrarInsumosPorNombre() {
            const busqueda = document.getElementById('buscarInsumo').value.toLowerCase();
            const filas = document.querySelectorAll('tbody tr');
            
            filas.forEach(fila => {
                const nombre = fila.cells[1].textContent.toLowerCase(); // Columna Nombre (index 1)
                if (nombre.includes(busqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
    </script>

    </body>
</html>

        
