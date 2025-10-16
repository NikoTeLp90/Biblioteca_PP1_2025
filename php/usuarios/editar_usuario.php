<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    editarUsuario($conexion, $_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cargo']);

    header("Location: listar_usuarios.php");
    exit();
}

$usuario_id = $_GET['id'];

$stmt = $conexion->prepare("SELECT nombre, apellido, email, cargo FROM usuario WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email, $cargo);
$stmt->fetch();
$stmt->close();
$conexion->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h3>Editando al usuario: <?php echo $nombre," ", $apellido; ?></h3>

    <form action="editar_usuario.php" method="post">

        <input type="hidden" name="id" value="<?php echo $usuario_id; ?>">

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>">
        <br><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" name="apellido" value="<?php echo $apellido; ?>">
        <br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo $email; ?>">
        <br><br>

        <label for="cargo">Cargo:</label><br>
        <select name="cargo">
          <option value="bibliotecario" <?php if($cargo == "bibliotecario") echo 'selected'; ?> >Bibliotecario</option>
          <option value="admin" <?php if($cargo == "admin") echo 'selected'; ?> >Administrador</option>
          <option value="secretario" <?php if($cargo == "secretario") echo 'selected'; ?> >Secretario</option>
        </select>
        <br><br>

        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
