<?php
header('Content-Type: text/html; charset=utf-8');
// No se debe incluir el archivo de la página de login aquí (evita inyectar el HTML del login)
// require_once __DIR__ . '/../php/login/login.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: php/login/login.php");
    exit();
}

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
    
    // Mensajes de creacion de prestamos o errores
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
    $tipo_mensaje = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    
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
    <link rel="stylesheet" href="./src/css/styles.css" />
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
              <a class="nav-link" href="index.php" id="linkInicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/insumos/listar_insumos.php" id="linkInsumos"
                >Insumos</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="php/prestamo/listar_prestamos.php" id="linkPrestamos">Préstamos</a>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" href="php/usuarios/listar_alumnos.php" id="linkUsuarios"
                >Usuarios</a>
            
            <li class="nav-item">
              <a class="nav-link" href="php/login/logout.php" id="linkUsuarios">Salir</a>
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

      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($mensaje); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Listado de insumos</h3>
        <button
          class="btn btn-danger"
          id="btnNuevoPrestamo"
        >
          Nuevo préstamo
        </button>
        <button
          class="btn btn-success d-none"
          id="btnConfirmarPrestamo"
          data-bs-toggle="modal"
          data-bs-target="#modalConfirmarPrestamo"
        >
          Confirmar préstamo (<span id="contadorSeleccionados">0</span>)
        </button>
        <button
          class="btn btn-secondary d-none"
          id="btnCancelarPrestamo"
        >
          Cancelar préstamo
        </button>
      </div>

      <div class="row mb-3">
        <div class="col-md-6 col-lg-4">
          <input
            type="text"
            class="form-control"
            id="inputBuscar"
            name="buscar"
            placeholder="Buscar..."
            onchange="filtrarInsumos()"
          />
        </div>
        <div class="col-md-2">
          <select class="form-select" id="selectEstado" name="estado" onchange="filtrarInsumos()">
            <option selected value="">Estado</option>
            <option value="Disponible">Disponible</option>
            <option value="No disponible">No disponible</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <?php if (!empty($insumos)): ?>
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th scope="col">Seleccionar</th>
              <th scope="col">Codigo</th>
              <th scope="col">Nombre</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($insumos as $insumo): ?>

            <!-- data-estado, data-nombre son para filtrar los insumos -->
            <tr data-estado="<?php echo htmlspecialchars($insumo['estado']); ?>"
               data-nombre="<?php echo htmlspecialchars(strtolower($insumo['nombre'])); ?>">
              <td>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input checkbox-seleccionar d-inline-block" onclick="toggleSeleccion(this)" data-insumo='<?php echo json_encode($insumo); ?>' 
                  <?php if (strtolower($insumo['disponibilidad']) !== 'disponible' || strtolower($insumo['estado']) !== 'disponible'): ?>disabled<?php endif; ?> />
                </div>
              </td>
              <td><?php echo htmlspecialchars($insumo['id']); ?></td>
              <td><?php echo htmlspecialchars($insumo['nombre']); ?></td>
              <td data-estado="<?php echo htmlspecialchars($insumo['estado']); ?>"><?php echo htmlspecialchars($insumo['estado']); ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
          <div class="alert alert-info">No hay insumos registrados en la base de datos.</div>
        <?php endif; ?>
      </div>
    </div>



    <script>
  function filtrarInsumos() {
  // Filtrado usando búsqueda (nombre) y selectEstado. Tabla ahora tiene columnas: Seleccionar, Codigo, Nombre, Estado
  const estado = document.getElementById('selectEstado')?.value || '';
  const busqueda = document.getElementById('inputBuscar')?.value.toLowerCase() || '';

    const filas = document.querySelectorAll('tbody tr');

    filas.forEach((fila) => {
        const filaNombre = fila.cells[2].textContent.toLowerCase().trim();
        const filaEstado = fila.cells[3].textContent.trim();

        const mostrarEstado = (estado === '' || (estado === 'No disponible' ? filaEstado !== 'Disponible' : filaEstado === estado));
        const mostrar = mostrarEstado && (busqueda === '' || filaNombre.includes(busqueda));

        fila.style.display = mostrar ? '' : 'none';
    });
}


      document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalPrestamo');
        const checklistEl = document.getElementById('insumosChecklist');
        const jsonHiddenEl = document.getElementById('insumosSeleccionadosJson');
        const form = document.getElementById('formPrestamo');
    
        const selectedMap = new Map();
    
        function updateHiddenJson() {
          const seleccionados = Array.from(selectedMap.values());
          const payload = { insumos: seleccionados };
          if (jsonHiddenEl) {
            jsonHiddenEl.value = JSON.stringify(payload);
          }
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
    
        if (modalEl) {
          modalEl.addEventListener('show.bs.modal', loadInsumos);
        }
    
        if (form && jsonHiddenEl) {
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
        }
      });
    </script>
    <!-- Modal de Confirmación de Préstamo -->
    <div class="modal fade" id="modalConfirmarPrestamo" tabindex="-1" aria-labelledby="modalConfirmarPrestamoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmarPrestamoLabel">
              Confirmar Préstamo
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <h6>Insumos seleccionados:</h6>
            <div id="listaInsumosSeleccionados" class="list-group mb-3">
              <!-- Aquí se mostrarán los insumos seleccionados -->
            </div>
            <form id="formPrestamo">
              <div class="mb-3">
                <label for="inputDestinatario" class="form-label">Destinatario</label>
                <input type="text" class="form-control" id="inputDestinatario" required>
              </div>
              <div class="mb-3">
                <label for="inputFechaLimite" class="form-label">Fecha límite</label>
                <input type="date" class="form-control" id="inputFechaLimite" required>
              </div>
              <div class="mb-3">
                <label for="inputObservacion" class="form-label">Observación</label>
                <input type="text" class="form-control" id="inputObservacion" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">
                Confirmar préstamo
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Variables globales
      let insumosSeleccionados = new Map();
      const btnNuevoPrestamo = document.getElementById('btnNuevoPrestamo');
      const btnConfirmarPrestamo = document.getElementById('btnConfirmarPrestamo');
      const contadorSeleccionados = document.getElementById('contadorSeleccionados');
      const botonesSeleccionar = document.querySelectorAll('.checkbox-seleccionar');
      const btnCancelarPrestamo = document.getElementById('btnCancelarPrestamo'); 

      // Función para alternar la selección de un insumo (checkbox)
      function toggleSeleccion(el) {
        const insumoData = JSON.parse(el.dataset.insumo);
        const insumoId = insumoData.id;

        if (el.checked) {
          insumosSeleccionados.set(insumoId, insumoData);
        } else {
          insumosSeleccionados.delete(insumoId);
        }

        // Actualizar contador
        contadorSeleccionados.textContent = insumosSeleccionados.size;

        // Actualizar JSON
        actualizarJSON();
      }

      // Función para actualizar el JSON de insumos seleccionados
      function actualizarJSON() {
        const insumosArray = Array.from(insumosSeleccionados.values());
        const jsonInsumos = JSON.stringify(insumosArray);
        console.log('Insumos seleccionados:', jsonInsumos);
        localStorage.setItem('insumosSeleccionados', jsonInsumos);
      }


      btnNuevoPrestamo.addEventListener('click', function() {

        botonesSeleccionar.forEach(chk => {
          chk.classList.remove('d-none');
          chk.checked = false;
        });
        
 
        btnNuevoPrestamo.classList.add('d-none');
        btnConfirmarPrestamo.classList.remove('d-none');
        btnCancelarPrestamo.classList.remove('d-none');
        

        insumosSeleccionados.clear();
        contadorSeleccionados.textContent = '0';
        localStorage.removeItem('insumosSeleccionados');
      });


      btnConfirmarPrestamo.addEventListener('click', function() {
        if (insumosSeleccionados.size === 0) {
          alert('Por favor, seleccione al menos un insumo.');
          return;
        }


        const listaInsumos = document.getElementById('listaInsumosSeleccionados');
        listaInsumos.innerHTML = '';
        
        insumosSeleccionados.forEach(insumo => {
          const item = document.createElement('div');
          item.className = 'list-group-item';
          item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="mb-0">${insumo.nombre}</h6>
                <small class="text-muted">Código: ${insumo.id}</small>
              </div>
              <span class="badge bg-primary">${insumo.categoria}</span>
            </div>
          `;
          listaInsumos.appendChild(item);
        });
      });


      btnCancelarPrestamo.addEventListener('click', function() {

        botonesSeleccionar.forEach(chk => {
          chk.classList.add('d-none');
          chk.checked = false;
        });
        

        btnConfirmarPrestamo.classList.add('d-none');
        btnCancelarPrestamo.classList.add('d-none');
        btnNuevoPrestamo.classList.remove('d-none');
        

        insumosSeleccionados.clear();
        contadorSeleccionados.textContent = '0';
        localStorage.removeItem('insumosSeleccionados');
      });


      document.getElementById('formPrestamo').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const destinatario = document.getElementById('inputDestinatario').value;
        const fechaLimite = document.getElementById('inputFechaLimite').value;
        const observacion = document.getElementById('inputObservacion').value;
        
        const prestamo = {
          insumos: Array.from(insumosSeleccionados.values()),
          destinatario: destinatario,
          fecha_limite: fechaLimite,
          observacion: observacion,
        };
        
        console.log('Procesando préstamo:', prestamo);
        
        // Redirigir a agregar_prestamo.php con los datos para crear el prestamo
        const insumosIds = prestamo.insumos.map(insumo => insumo.id).join(',');
        const url = `php/prestamo/agregar_prestamo.php?destinatario=${encodeURIComponent(destinatario)}&insumos=${insumosIds}&fecha_limite=${encodeURIComponent(fechaLimite)}&observacion=${encodeURIComponent(observacion)}`;
        window.location.href = url;


        const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarPrestamo'));
        modal.hide();

        btnCancelarPrestamo.click();
      });
    </script>
  </body>
</html>