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

// Mensajes
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo_mensaje = isset($_GET['tipo']) ? $_GET['tipo'] : '';

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
            <h2>INSUMOS - BIBLIOTECA I.S.F.T. N°12</h2>
        </div>

        <!-- Mensajes -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-5 mb-3">
                <input type="text" class="form-control" id="inputBuscar" placeholder="Buscar insumo por nombre...">
            </div>
            <div class="col-md-7 text-md-end text-center">
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNuevoInsumo">
                    <i class="bi bi-plus-circle-fill"></i> Alta de Insumo
                </button>
            </div>
        </div>

        <h1>Insumos Cargados</h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="insumosTable">
                <thead class="table-dark">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>   
                        <th>Categoria</th>
                        <th>Disponibilidad</th>
                        <th>Estado</th>
                        <th>Observacion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($insumos) > 0) {
                        foreach ($insumos as $insumo):
                            $enPrestamo = ($insumo['disponibilidad'] === 'En Préstamo');
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($insumo['id']); ?></td>
                                <td><?php echo htmlspecialchars($insumo['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($insumo['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($insumo['disponibilidad']); ?></td>
                                <td><?php echo htmlspecialchars($insumo['estado']); ?></td>
                                <td><?php echo htmlspecialchars($insumo['observaciones'] ?? '-'); ?></td>
                                <td>
                                    <?php if ($enPrestamo): ?>
                                        Sin acciones disponibles.
                                    <?php else: ?>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary" 
                                                    data-bs-toggle="modal" data-bs-target="#modalEditarInsumo"
                                                    onclick="cargarDatosEdicion(<?php echo htmlspecialchars(json_encode($insumo)); ?>)">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="confirmarEliminacion(<?php echo $insumo['id']; ?>, '<?php echo htmlspecialchars(addslashes($insumo['nombre'])); ?>')">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    } else {
                        echo '<tr><td colspan="7" class="text-center">No hay insumos registrados</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL NUEVO INSUMO -->
    <div class="modal fade" id="modalNuevoInsumo" tabindex="-1" aria-labelledby="modalNuevoInsumoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoInsumoLabel">Registrar Nuevo Insumo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="agregar_insumo.php" method="POST" id="registroInsumo">
                        <div class="mb-3">
                            <label for="cantidad" class="form-label fw-bold">Cantidad de unidades</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1" required onchange="generarInputsInsumos()">
                        </div>
                        <div id="contenedorInsumos">
                            <!-- Aquí se generarán dinámicamente los inputs de nombre y observación -->
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-danger">Guardar Insumo(s)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR INSUMO -->
    <div class="modal fade" id="modalEditarInsumo" tabindex="-1" aria-labelledby="modalEditarInsumoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarInsumoLabel">Editar Insumo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="editar_insumo.php" method="POST" id="formEditarInsumo">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEstado" class="form-label fw-bold">Estado</label>
                            <select class="form-select" id="editEstado" name="estado" required>
                                <option value="disponible">Disponible</option>
                                <option value="en_reparacion">En Reparación</option>
                                <option value="fuera_servicio">Fuera de Servicio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editObservacion" class="form-label fw-bold">Observación</label>
                            <textarea class="form-control" id="editObservacion" name="observaciones" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-danger" id="submitEditar">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para eliminar -->
    <form id="formEliminar" action="eliminar_insumo.php" method="POST" style="display:none;">
        <input type="hidden" id="eliminarId" name="id">
    </form>

    <script>
        // Función para generar inputs dinámicamente según la cantidad
        function generarInputsInsumos() {
            const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
            const contenedor = document.getElementById('contenedorInsumos');
            
            // Limpiar contenedor
            contenedor.innerHTML = '';
            
            // Generar inputs para cada unidad, máximo 2 por fila
            let filaActual = null;
            for (let i = 1; i <= cantidad; i++) {
                // Crear nueva fila cada 2 insumos o si es el primero
                if ((i - 1) % 2 === 0) {
                    filaActual = document.createElement('div');
                    filaActual.className = 'row mb-3';
                    contenedor.appendChild(filaActual);
                }
                
                // Crear columna (máximo 2 por fila, cada una ocupa 6 columnas de 12)
                const columna = document.createElement('div');
                columna.className = 'col-md-6';
                
                const card = document.createElement('div');
                card.className = 'card h-100';
                card.innerHTML = `
                    <div class="card-header bg-light">
                        <strong>Insumo ${i}</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre_${i}" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="nombre_${i}" name="nombres[]" required>
                        </div>
                        <div class="mb-3">
                            <label for="observacion_${i}" class="form-label fw-bold">Observación</label>
                            <textarea class="form-control" id="observacion_${i}" name="observaciones[]" rows="2"></textarea>
                        </div>
                    </div>
                `;
                
                columna.appendChild(card);
                filaActual.appendChild(columna);
            }
        }
        
        // Generar inputs al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            generarInputsInsumos();
        });

        // Función para cargar datos en el modal de edición
        function cargarDatosEdicion(insumo) {
            // Convertir etiquetas a claves para los selects
            const estadoMap = {
                'Disponible': 'disponible',
                'En Reparación': 'en_reparacion',
                'Fuera de Servicio': 'fuera_servicio'
            };

            document.getElementById('editId').value = insumo.id;
            document.getElementById('editNombre').value = insumo.nombre || '';
            document.getElementById('editEstado').value = estadoMap[insumo.estado] || 'disponible';
            document.getElementById('editObservacion').value = insumo.observaciones || '';
        }

        // Función para confirmar eliminación
        function confirmarEliminacion(id, nombre) {
            if (confirm(`¿Está seguro que desea eliminar el insumo "${nombre}" (Código: ${id})?`)) {
                document.getElementById('eliminarId').value = id;
                document.getElementById('formEliminar').submit();
            }
        }
    </script>
</body>
</html>
