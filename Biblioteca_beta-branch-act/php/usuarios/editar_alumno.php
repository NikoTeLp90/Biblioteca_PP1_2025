<?php
session_start();
include '../../sql/db_functions.php';


// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];
    $usuario = obtenerUsuarioPorId($conexion, $usuario_id);


    
} else {
    echo "No se ha recibido el ID del usuario.";
    exit;
}
?>

<form action="" method="post">
    <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario_id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required value="<?php echo htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required value="<?php echo htmlspecialchars($usuario['apellido'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" placeholder="Ingrese un DNI" required value="<?php echo htmlspecialchars($usuario['dni'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label for="email">Email:</label>
        <input type="text" name="email" required value="<?php echo htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><br>

        <label for="cargo">Cargo:</label>
        <select name="cargo" value="<?php echo htmlspecialchars($usuario['cargo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <option value="bibliotecario" <?php echo (isset($usuario['cargo']) && strtolower($usuario['cargo']) === 'bibliotecario') ? 'selected' : ''; ?>>Bibliotecario</option>
            <option value="admin" <?php echo (isset($usuario['cargo']) && strtolower($usuario['cargo']) === 'admin') ? 'selected' : ''; ?>>Administrador</option>
            <option value="secretario" <?php echo (isset($usuario['cargo']) && strtolower($usuario['cargo']) === 'secretario') ? 'selected' : ''; ?>>Secretario</option>
        </select>

        <input type="submit" value="Guardar">
        <a href="../../index.html">Volver al index</a>
        <button type="button" onclick="window.location.href='../../index.html';">Ir al Index</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];

    editarUsuario($conexion, $usuario_id, $nombre, $apellido, $dni, $email, $cargo);
}
?>