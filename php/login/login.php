<?php
session_start();

include '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $contrasenia = trim($_POST["contrasenia"]);
    $usuario = obtenerUsuarioByEmail($conexion, $email);
    if($usuario){
        if(password_verify($contrasenia, $usuario['contrasenia'])){
            $_SESSION['usuario'] = $usuario;
            header("Location: ../bienvenido.php");
        }else{
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: ../error.php");
        }
    }else{
        $_SESSION['error'] = "Usuario no encontrado";
        header("Location: ../error.php");
    }
}
?>

<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <h1>Ingresar</h1>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Ingrese un email" required>
            <br>
            <label for="contrasenia">Contraseña:</label>
            <input type="password" name="contrasenia" placeholder="Ingrese una contraseña" required>
            <br>
            <input type="submit" value="Ingresar">
        </form>
    </body>
</html>