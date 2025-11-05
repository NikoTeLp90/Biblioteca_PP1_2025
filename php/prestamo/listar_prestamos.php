<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

// session_start();

// // INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

$prestamos = obtenerPrestamos($conexion);
if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    echo json_encode($prestamos);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Préstamos</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      defer
    ></script>
    <script src="prestamos.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img
            src="../../src/img/logo i12 fondo blanco.png"
            alt="Logo"
            class="d-inline-block align-text-top me-2"
            style="height: 40px"
          />
          Instituto Superior de Formación Técnica Nº 12 
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="../.." id="linkInicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../php/insumos/agregar_insumo.php" id="linkInsumos"
                >Insumos</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active"
                href="../../php/prestamo/listar_prestamos.php" id="linkPrestamos"
                >Préstamos</a
              >
            </li>

            <li class="nav-item"><a class="nav-link" href="../../php/usuarios/listar_alumnos.php" id="linkUsuarios">Usuarios</a>


            <li class="nav-item">
              <a class="nav-link" href="../../php/login/logout.php" id="linkSalir">Salir</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
      <div class="text-center mb-4">
        <h2>
            <img
            src="../../src/img/logo i12 fondo blanco.png"
            alt="Logo"
            class="d-inline-block align-text-top me-2"
            style="height: 40px" />
            Gestión de Préstamos
        </h2>
      </div>

      <ul class="nav nav-tabs mb-4" id="prestamosTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link active"
            id="activos-tab"
            data-bs-toggle="tab"
            data-bs-target="#activos"
            type="button"
            role="tab"
            aria-controls="activos"
            aria-selected="true"
          >
            Activos
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="morosos-tab"
            data-bs-toggle="tab"
            data-bs-target="#morosos"
            type="button"
            role="tab"
            aria-controls="morosos"
            aria-selected="false"
          >
            Morosos
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="historial-tab"
            data-bs-toggle="tab"
            data-bs-target="#historial"
            type="button"
            role="tab"
            aria-controls="historial"
            aria-selected="false"
          >
            Historial (Devueltos)
          </button>
        </li>
      </ul>

      <div class="tab-content" id="prestamosTabsContent">
        <div
          class="tab-pane fade show active"
          id="activos"
          role="tabpanel"
          aria-labelledby="activos-tab"
        >
          <div class="table-responsive">
            <table id="prestamosTabla" class="table table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th scope="col">Insumo</th>
                  <th scope="col">Destinatario</th>
                  <th scope="col">F. Préstamo</th>
                  <th scope="col">F. Límite</th>
                  <th scope="col">Acción</th>
                </tr>
              </thead>
              <tbody id="listaActivos"></tbody>
              <?php
                if (count($prestamos) > 0) {
                    foreach ($prestamos as $prestamo):
                        echo '<tr>';
                        echo '<td>' . $prestamo['insumo_nombre'] . '</td>';
                        echo '<td>' . $prestamo['destinatario'] . '</td>';
                        echo '<td>' . $prestamo['fecha_prestamo'] . '</td>';
                        echo '<td>' . $prestamo['fecha_limite'] . '</td>';
                        echo '<td>
                                <a href="../prestamos/editar_prestamo.php?id=' . $prestamo['id'] . '">Editar</a>
                                <form action="../prestamos/eliminar_prestamo.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="' . $prestamo['id'] . '">
                                <button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este préstamo?\')">Eliminar</button>    
                                </form>
                            </td>';
                        echo '</tr>';
                    endforeach;
                } else {
                    echo '<h1>No hay insumos registrados</h1>';
                }

                ?>
            </table>
          </div>
        </div>

        <div
          class="tab-pane fade"
          id="morosos"
          role="tabpanel"
          aria-labelledby="morosos-tab"
        >
          <div class="alert alert-warning" role="alert">
            Listado de préstamos cuya Fecha Límite es anterior a la fecha
            actual.
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-warning">
                <tr>
                  <th scope="col">Cód. Préstamo</th>
                  <th scope="col">Insumo</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Destinatario</th>
                  <th scope="col">F. Préstamo</th>
                  <th scope="col">F. Límite</th>
                  <th scope="col">Acción</th>
                </tr>
              </thead>
              <tbody id="listaMorosos"></tbody>
            </table>
          </div>
        </div>

        <div
          class="tab-pane fade"
          id="historial"
          role="tabpanel"
          aria-labelledby="historial-tab"
        >
          <div class="alert alert-info" role="alert">
            Préstamos ya devueltos. Se puede eliminar del historial.
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-info">
                <tr>
                  <th scope="col">Cód. Préstamo</th>
                  <th scope="col">Insumo</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Destinatario</th>
                  <th scope="col">F. Devolución</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="listaHistorial"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="prestamos.js" type="module"></script>
</html>
