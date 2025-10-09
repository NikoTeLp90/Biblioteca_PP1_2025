<?php
include '../sql/db_functions.php';


if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    $query = "SELECT nombre, apellido, email, cargo, contrasena FROM usuario WHERE id = ?";
    if ($stmt = $conexion->prepare($query)) {

        $stmt->bind_param("i", $usuario_id);
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
        <input type="text" name="nombre" placeholder="Ingrese un nombre" required>
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" placeholder="Ingrese un apellido" required>
        <br>

        <label for="email">Email:</label>
        <input type="text" name="email" required><br>

        <label for="cargo">Cargo:</label>
        <select name="cargo">
            <option value="bibliotecario">Bibliotecario</option>
            <option value="admin">Administrador</option>
            <option value="secretario">Secretario</option>
        </select>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Guardar">
        <a href="../index.html">Volver al index</a>
        <button type="button" onclick="window.location.href='../index.html';">Ir al Index</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $contrasena = $_POST['contrasena'];

    
    editarUsuario($conexion, $usuario_id, $nombre, $apellido, $email, $cargo, $contrasena);
}
?>