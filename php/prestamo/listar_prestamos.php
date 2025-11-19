<?php
require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// Verificar login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

// Obtener filtro
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'activos';
$prestamos = obtenerPrestamos($conexion, $filtro);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../src/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../../src/img/logo i12 fondo blanco.png" alt="Logo" class="d-inline-block align-text-top me-2" style="height: 40px;">
                Instituto Superior de Formación Técnica Nº 12 
            </a>

             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../php/insumos/listar_insumos.php">Insumos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../../php/prestamo/listar_prestamos.php">Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../php/usuarios/listar_alumnos.php">Usuarios</a>
                    <li class="nav-item"><a class="nav-link" href="../../php/login/logout.php">Salir</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>Gestión de Préstamos</h2>
        </div>

        <!-- Filtros -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?php echo $filtro === 'activos' ? 'active' : ''; ?>" href="?filtro=activos">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $filtro === 'morosos' ? 'active' : ''; ?>" href="?filtro=morosos">Morosos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $filtro === 'historial' ? 'active' : ''; ?>" href="?filtro=historial">Historial</a>
            </li>
        </ul>

        <!-- Tabla -->
        <div class="table-responsive">
            <?php if (count($prestamos) > 0): ?>
             <table class="table table-hover">
                 <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Insumo</th>
                        <th scope="col">Destinatario</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Límite</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestamos as $prestamo): ?>
                        <?php 
                            $estadoClass = '';
                            $estadoTexto = '';
                            
                            if ($prestamo['activo']) {
                                $fechaLimite = new DateTime($prestamo['fecha_final']);
                                $ahora = new DateTime();
                                
                                if ($fechaLimite < $ahora) {
                                    $estadoClass = 'text-danger fw-bold';
                                    $estadoTexto = 'Vencido';
                                } else {
                                    $estadoClass = 'text-success fw-bold';
                                    $estadoTexto = 'Activo';
                                }
                            } else {
                                $estadoClass = 'text-muted';
                                $estadoTexto = 'Devuelto';
                            }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prestamo['id']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($prestamo['insumo_nombre']); ?>
                                <br>
                                <small class="text-muted"><?php echo htmlspecialchars($prestamo['insumo_categoria']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($prestamo['destinatario']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($prestamo['fecha_inicio'])); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($prestamo['fecha_final'])); ?></td>
                            <td class="<?php echo $estadoClass; ?>"><?php echo $estadoTexto; ?></td>
                            <td>
                                <?php if ($prestamo['activo']): ?>
                                    <form action="devolver_prestamo.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $prestamo['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('¿Confirmar devolución?')">Devolver</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    No se encontraron préstamos para el filtro seleccionado.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>