<?php

require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    #$cantidad = trim($_POST["cantidad"]);
    #$categoria = trim($_POST["categoria"]);
    #$disponibilidad = trim($_POST["disponibilidad"]);
    #$estado = trim($_POST["estado"]);
    $observaciones = trim($_POST["observaciones"]);

    $exitosos = 0;
    $errores = 0;

    for ($i = 0; $i < $cantidad; $i++) {
        if (agregarInsumo($conexion, $nombre, $observaciones)) {
            $exitosos++;
        } else {
            $errores++;
        }
    }

    if ($errores == 0) {
        $mensaje = "Se agregaron correctamente $exitosos insumo(s)";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Se agregaron $exitosos insumo(s) correctamente, pero hubo $errores error(es)";
        $tipo_mensaje = "warning";
    }
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
                    <li class="nav-item"><a class="nav-link" href="../../php/prestamo/listar_prestamos.php" id="linkPrestamos">Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../php/usuarios/listar_alumnos.php" id="linkUsuarios">Usuarios</a>
                    <li class="nav-item"><a class="nav-link" href="../../login/logout.php" id="linkSalir">Salir</a></li>
                    
                   
                </ul>
            </div>
        </div>
    </nav>

      <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>Alta de insumos - BIBLIOTECA I.S.F.T. N°12</h2>
        </div>

        <!-- FORMULARIO EN CARD -->
        <div class="card p-4 mb-4">
            <form action="" method="post" id="registroInsumo">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="">Seleccionar</option>
                            <option value="tecnologia">Tecnología</option>
                            <option value="bibliografia">Bibliografía</option>
                            <option value="electrico">Eléctrico</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- Cantidad dinámica (no se envía al backend porque no tiene name) -->
                        <div class="mb-3">
                            <label for="inputCantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="inputCantidad" min="1" value="1">
                            <small class="form-text text-muted">Solo controla cuántos ítems se crean. No se guarda en la base de datos.</small>
                        </div>
                        
                        <!-- Contenedor donde se generan N bloques de Nombre (copiado) + Observación -->
                        <div id="duplicadosContainer"></div>
                    </div>
                    <!-- Contenedor donde se agregarán filas dinámicas para cada unidad -->
                    <div class="col-12">
                        <div id="unidadesContainer" class="mt-3"></div>
                    </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold">Disponibilidad</label>
                        <select class="form-select" id="estado" name="disponibilidad" required>
                            <option value="">Seleccionar</option>
                            <option value="disponible">Disponible</option>
                            <option value="en_reparacion">En Reparación</option>
                            <option value="fuera_servicio">Fuera de Servicio</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="">Seleccionar</option>
                            <option value="disponible">Disponible</option>
                            <option value="en_prestamo">En Prestamo</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Observación</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Escribí tus comentarios acá..." rows="3"></textarea>
                    </div>
                </div>

                <div id="mensaje" class="mt-3">
                    <?php if (isset($mensaje)): ?>
                        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($mensaje); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger me-2">Guardar Insumo</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<script>
(function() {
    const cantidadEl = document.getElementById('inputCantidad');
    const container = document.getElementById('duplicadosContainer');
    // Detecta el campo original de nombre y observación
    const masterNameEl = document.querySelector('input[name="nombre"]');
    const masterObsEl = document.querySelector('input[name="observacion"]') || document.querySelector('input[name="observaciones"]');

    function getCantidad() {
        const n = parseInt(cantidadEl.value, 10);
        return isNaN(n) || n < 1 ? 1 : n;
    }

    function renderDuplicados() {
        const n = getCantidad();
        const masterVal = masterNameEl ? masterNameEl.value : '';
        container.innerHTML = '';

        // Si Cantidad es 1, no agregamos duplicados
        if (n <= 1) return;

        const dupCount = n - 1;
        for (let i = 1; i <= dupCount; i++) {
            const wrapper = document.createElement('div');
            wrapper.className = 'border rounded p-2 mb-2';

            // Nombre (copiado del original)
            const groupNombre = document.createElement('div');
            groupNombre.className = 'mb-2';
            groupNombre.innerHTML = `
                <label class="form-label">Nombre (copiado) ${i + 1}</label>
                <input type="text" class="form-control" name="nombres[]" value="${masterVal}" readonly>
            `;

            // Observación por ítem
            const groupObs = document.createElement('div');
            groupObs.className = 'mb-2';
            groupObs.innerHTML = `
                <label class="form-label">Observación ${i + 1}</label>
                <input type="text" class="form-control" name="observaciones[]">
            `;

            wrapper.appendChild(groupNombre);
            wrapper.appendChild(groupObs);
            container.appendChild(wrapper);
        }
    }

    // Redibujar al cambiar cantidad
    cantidadEl.addEventListener('input', renderDuplicados);

    // Mantener sincronizados los nombres duplicados si cambia el original
    if (masterNameEl) {
        masterNameEl.addEventListener('input', () => {
            document.querySelectorAll('input[name="nombres[]"]').forEach(el => {
                el.value = masterNameEl.value;
            });
        });
    }

    // Inicializar
    renderDuplicados();
})();
</script>
