<?php
include '../sql/db_functions.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT nombre, apellido, email, cargo, contrasena FROM usuario WHERE id = ?";
    if ($stmt = $conexion->prepare($query)) {

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nombre, $apellido, $email, $cargo, $contrasena);
        $stmt->fetch();
        $stmt->close();
    }
} else {
    echo "No se ha recibido el ID del usuario.";
    exit;
}
?>

<form action="" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
    <br>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
    <br>

    <label for="email">Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

    <label for="cargo">Cargo:</label>
    <select name="cargo">
        <option value="bibliotecario" <?php if($cargo=='bibliotecario') echo 'selected'; ?>>Bibliotecario</option>
        <option value="admin" <?php if($cargo=='admin') echo 'selected'; ?>>Administrador</option>
        <option value="secretario" <?php if($cargo=='secretario') echo 'selected'; ?>>Secretario</option>
    </select>

    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" value="<?php echo htmlspecialchars($contrasena); ?>" required><br>

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="submit" value="Guardar">
    <a href="../index.html">Volver al index</a>
    <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $contrasena = $_POST['contrasena'];

    
    editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena);
}
?>