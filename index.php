<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require 'config/connect.php';
    require 'sql/db_functions.php';
    
    if (!isset($conexion) || $conexion->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . ($conexion->connect_error ?? 'No hay conexión'));
    }
    
    $insumos = obtenerInsumos($conexion);
    if ($insumos === false) {
        throw new Exception("Error al obtener insumos");
    }
    
    if (isset($_GET['json'])) {
        header('Content-Type: application/json');
        echo json_encode($insumos);
        exit();
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Insumos</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="src/css/styles.css" />
    <!-- <script src="home.js" defer></script> -->
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img
            src="src/img/logo i12 fondo blanco.png"
            alt="Logo"
            class="d-inline-block align-text-top me-2"
            style="height: 40px"
          />
          Instituto Superior de Formación Técnica Nº 12 
        </a>
        <!-- boton que dijo el profe para el navbar responsive -->
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
              <a class="nav-link" href="index.html" id="linkInicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/insumos/listar_insumos.php" id="linkInsumos"
                >Insumos</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../prestamos/prestamos.html" id="linkPrestamos">Préstamos</a>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" href="php/usuarios/listar_alumnos.php" id="linkUsuarios"
                >Usuarios</a>
            
            <li class="nav-item">
              <a class="nav-link" href="#" id="linkUsuarios">salir</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <div class="row text-center mb-4">
        <div class="col-md-3">
          <div class="card p-3">
            <h5 class="card-title text-muted">Total de insumos disponibles</h5>
            <h2 class="card-text fw-bold" id="totalInsumos">0</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3">
            <h5 class="card-title text-muted">Insumos prestados actualmente</h5>
            <h2 class="card-text fw-bold" id="insumosPrestados">0</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3">
            <h5 class="card-title text-muted">
              Insumos en reparación o fuera de servicio
            </h5>
            <h2 class="card-text fw-bold" id="insumosReparacion">0</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3">
            <h5 class="card-title text-muted">
              Usuarios con préstamos activos
            </h5>
            <h2 class="card-text fw-bold" id="usuariosActivos">0</h2>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Listado de insumos</h3>
        <div>
          <button class="btn btn-danger" id="btnNuevoPrestamo">
            Nuevo préstamo
          </button>
          <button class="btn btn-success d-none" id="btnConfirmarPrestamo">
            Confirmar selección (<span id="contadorSeleccionados">0</span>)
          </button>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <input
            type="text"
            class="form-control"
            id="inputBuscar"
            name="buscar"
            placeholder="Buscar..."
          />
        </div>
        <div class="col-md-2">
          <select class="form-select" id="selectCategoria" name="categoria">
            <option selected>Categoría</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select" id="selectEstado" name="estado">
            <option selected>Estado</option>
            <option value="disponible">Disponible</option>
            <option value="prestado">Prestado</option>
            <option value="reparacion">En reparación</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select" id="selectUbicacion" name="ubicacion">
            <option selected>Ubicación</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <?php if (!empty($insumos)): ?>
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th scope="col">Codigo</th>
              <th scope="col">Nombre</th>
              <th scope="col">Categoria</th>
              <th scope="col">Disponibilidad</th>
              <th scope="col">Estado</th>
              <th scope="col">Observacion</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($insumos as $insumo): 
            // Solo mostrar insumos disponibles
            if ($insumo['disponibilidad'] === 'disponible'): ?>
            <tr data-insumo-id="<?php echo htmlspecialchars($insumo['id']); ?>">
              <td><?php echo htmlspecialchars($insumo['id']); ?></td>
              <td><?php echo htmlspecialchars($insumo['nombre']); ?></td>
              <td><?php echo htmlspecialchars($insumo['categoria']); ?></td>
              <td><?php echo htmlspecialchars($insumo['disponibilidad']); ?></td>
              <td><?php echo htmlspecialchars($insumo['estado']); ?></td>
              <td><?php echo htmlspecialchars($insumo['observaciones']); ?></td>
              <td>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-sm btn-outline-primary btn-seleccionar d-none" onclick="toggleSeleccion(this)" data-insumo='<?php echo json_encode($insumo); ?>'>
                    Seleccionar
                  </button>
                </div>
              </td>
            </tr>
          <?php endif; ?>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
          <div class="alert alert-info">No hay insumos registrados en la base de datos.</div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Modal sacado de BOOSTRAP :) Nuevo Préstamo -->
    <div
      class="modal fade"
      id="modalPrestamo"
      tabindex="-1"
      aria-labelledby="modalPrestamoLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPrestamoLabel">
              <img
                src="../multimedia/logo.png"
                alt="Logo"
                class="d-inline-block align-text-top me-2"
                style="height: 40px"/>
              Registrar nuevo préstamo
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Cerrar"
            ></button>
          </div>

          <div class="modal-body">
            <form id="formPrestamo">
              <div class="mb-3">
                <label class="form-label">Selecciona insumos</label>
                <div id="insumosChecklist" class="list-group" style="max-height: 250px; overflow-y: auto;"></div>
                <input type="hidden" id="insumosSeleccionadosJson" name="insumosSeleccionadosJson" />
                <div class="form-text">Marca los insumos que quieres incluir en el préstamo.</div>
              </div>

              <div class="mb-3">
                <label for="inputDestinatario" class="form-label"
                  >Destinatario</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="inputDestinatario"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="inputFechaLimite" class="form-label"
                  >Fecha límite</label
                >
                <input
                  type="date"
                  class="form-control"
                  id="inputFechaLimite"
                  required
                />
              </div>

              <button type="submit" class="btn btn-danger w-100">
                Guardar préstamo
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalPrestamo');
        const checklistEl = document.getElementById('insumosChecklist');
        const jsonHiddenEl = document.getElementById('insumosSeleccionadosJson');
        const form = document.getElementById('formPrestamo');
    
        const selectedMap = new Map();
    
        function updateHiddenJson() {
          const seleccionados = Array.from(selectedMap.values());
          const payload = { insumos: seleccionados };
          jsonHiddenEl.value = JSON.stringify(payload);
        }
    
        function renderChecklist(insumos) {
          checklistEl.innerHTML = '';
          if (!insumos || insumos.length === 0) {
            checklistEl.innerHTML = '<div class="text-muted px-2">No hay insumos disponibles.</div>';
            return;
          }
          insumos
            .filter(i => (i.disponibilidad || '').toLowerCase() === 'disponible')
            .forEach(i => {
              const item = document.createElement('label');
              item.className = 'list-group-item d-flex align-items-center gap-2';
    
              const cb = document.createElement('input');
              cb.type = 'checkbox';
              cb.className = 'form-check-input me-2';
              cb.id = 'insumo_' + i.id;
              cb.dataset.id = i.id;
              cb.dataset.nombre = i.nombre;
              cb.dataset.categoria = i.categoria;
    
              cb.addEventListener('change', () => {
                const key = String(i.id);
                if (cb.checked) {
                  selectedMap.set(key, { id: i.id, nombre: i.nombre, categoria: i.categoria });
                } else {
                  selectedMap.delete(key);
                }
                updateHiddenJson();
              });
    
              const info = document.createElement('div');
              info.className = 'flex-grow-1';
              info.innerHTML = `<strong>${i.nombre}</strong> <span class="text-muted">(${i.categoria || 'Sin categoría'})</span> <span class="badge bg-secondary ms-2">ID: ${i.id}</span>`;
    
              item.appendChild(cb);
              item.appendChild(info);
              checklistEl.appendChild(item);
            });
    
          updateHiddenJson();
        }
    
        function loadInsumos() {
          checklistEl.innerHTML = '<div class="px-2">Cargando insumos...</div>';
          fetch('php/insumos/listar_insumos.php?json=1')
            .then(r => r.json())
            .then(data => {
              selectedMap.clear();
              renderChecklist(Array.isArray(data) ? data : []);
            })
            .catch(err => {
              console.error('Error cargando insumos', err);
              checklistEl.innerHTML = '<div class="text-danger px-2">No se pudieron cargar los insumos.</div>';
            });
        }
    
        modalEl.addEventListener('show.bs.modal', loadInsumos);
    
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          const destinatario = document.getElementById('inputDestinatario').value;
          const fechaLimite = document.getElementById('inputFechaLimite').value;
          const payload = {
            destinatario,
            fechaLimite,
            insumos: Array.from(selectedMap.values())
          };
          jsonHiddenEl.value = JSON.stringify(payload);
          console.log('Préstamo JSON:', jsonHiddenEl.value);
          alert('Préstamo preparado:\n' + jsonHiddenEl.value);
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>