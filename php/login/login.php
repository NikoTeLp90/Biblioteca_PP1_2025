<?php
session_start();

include '../../sql/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $dni = trim($_POST["dni"]);
    $contrasenia = trim($_POST["contrasenia"]);
    $usuario = obtenerUsuarioPorDni($conexion, $dni);
    if($usuario){
        if(password_verify($contrasenia, $usuario['contrasenia'])){
            $_SESSION['usuario'] = $usuario;
            header("Location: ../../index.php");
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO DE SESIÓN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100 p-0">
        <div class="row m-0 w-100 shadow-lg login-box">
            <div class="col-md-4 bg-dark text-white d-flex flex-column justify-content-center align-items-center p-4 text-center">
                <img src="../../src/img/logo i12 fondo blanco.png" alt="Instituto Superior de Formación Técnica N°12" class="img-fluid mb-3 logo-img">
                <p class="h6 fw-normal">INSTITUTO SUPERIOR DE FORMACION TECNICA N°12</p>
            </div>
            
            <div class="col-md-8 bg-white d-flex flex-column justify-content-center align-items-center p-4">
                <div class="w-100 login-form-wrapper">
                    <h2 class="text-danger mb-4 text-center fw-bold">Inicio de sesión</h2>
                    <form action="" method="post" id="forms">
                        <div class="mb-3">
                            <label for="dni" class="form-label fw-bold">Ingrese su DNI *</label>
                            <input type="text" class="form-control" id="dni" name ="dni" placeholder="DNI" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Contraseña *</label>
                            <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Ingrese su clave" required>
                            <p id="parrafo"> </p>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 my-3 fw-bold">Acceder</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Elimina el contenido del local storage de la clave indicada
    <script>
        localStorage.removeItem('datosLocal');
    </script>
    -->
    <script src="index.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>