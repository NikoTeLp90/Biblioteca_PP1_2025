<?php

#session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

include '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = trim($_POST["nombre"]);
  $apellido = trim($_POST["apellido"]);
  $email = trim($_POST["email"]);
  $cargo = trim($_POST["cargo"]);
  $contrasena = trim($_POST["contrasena"]);

  // Validación mínima en servidor: la contraseña no puede estar vacía
  if (empty($contrasena)) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "La contraseña es requerida"]);
    exit;
  }

  $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
  crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena);
}
  #exit();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ALTA USUARIO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../src/css/styles.css">
</head>

<body>

 
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../src/img/logo.png" alt="Logo" class="d-inline-block align-text-top me-2" style="height: 40px" />
        Instituto Superior de Formación Técnica Nº 12
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.html" id="linkInicio">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../php/listar_insumos.php" id="linkInsumos">Insumos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../prestamos/prestamos.html" id="linkPrestamos">Préstamos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../php/listar_alumnos.php" id="linkUsuarios">Usuarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="linkSalir">Salir</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

 
  <div class="container mt-4">
    <h2 class="text-center mb-4">Alta de Usuario</h2>

    <form id="altaUsuarioForm" method="POST">
      <div class="mb-3">
        <label for="nombre" class="form-label fw-bold">Nombre</label>
        <input type="text" class="form-control" id="nombre" name = "nombre" required>
      </div>

       <div class="mb-3">
        <label for="apellido" class="form-label fw-bold">Apellido</label>
        <input type="text" class="form-control" id="apellido" name = "apellido" required>
      </div>

      <div class="mb-3">
        <label for="dni" class="form-label fw-bold">DNI</label>
        <input type="number" class="form-control" id="dni" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control" id="email" name = "email" required>
      </div>

      <div class="mb-3">
        <label for="cargo" class="form-label fw-bold">Cargo</label>
        <select class="form-select border-dark" id="cargo" name="cargo" required>
          <option selected disabled>Seleccionar</option>
          <option>Bibliotecario</option>
          <option>Secretario</option>
          <option>Admin</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="contrasena" class="form-label fw-bold">Contraseña</label>
        <input type="password" class="form-control" id="altaPassword" name="contrasena" required>
      </div>

      <div class="mb-3">
        <label for="altaPassword2" class="form-label fw-bold">Repetir Contraseña</label>
        <input type="password" class="form-control" id="altaPassword2" required>
      </div>

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-danger">Alta Usuario</button>
      </div>

      <div class="text-center mb-3">
        <p id="repeatPass"></p>
      </div>

      <div id="mensaje"></div>
    </form>
  </div>

  <script src="../src/js/altaUser.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

