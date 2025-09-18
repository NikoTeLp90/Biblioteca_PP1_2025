<?php
include '../config/config.php';
include '../config/connect.php';

function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena){
    $query = "INSERT INTO usuario (nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query) ){
        $stmt ->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena);

        if($stmt->execute()){
            echo "Alumno creado correctamente";
            
            exit();
        }else {
            echo "Error al crear alumno: ". $stmt ->error;

        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function editarUsuarios($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena){
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, cargo = ?, contraseña = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query) ){
        $stmt ->bind_param("sssssi", $nombre, $apellido, $email, $cargo, $contrasena);

        if($stmt->execute()){
            echo "Alumno creado correctamente";
            
            exit();
        }else {
            echo "Error al crear alumno: ". $stmt ->error;

        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

