<?php
include '../config/config.php';
include '../config/connect.php';

function crearEj1($conexion, $nombre, $apellido, $email, $cargo, $contrasenia) {
    $query ="INSERT INTO usuario(nombre, apellido, email, cargo, contrasenia) VALUE (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sss", $nombre, $apellido, $email, $cargo, $contrasenia);

        if ($stmt->execute()) {
            echo "alumno creado correctamente";
            exit();
        }else{
            echo "error al crear ejercicio 1: ". $stmt->error;
        }
        
    }else{
            echo "error al crear ejercicio 1: ".$query."<br>". $conexion->error;
    }
}

function editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasenia) {
    $query="UPDATE usuario SET nombre=?, apellido=?, email=?, cargo=?, contrasenia=? WHERE id=?";
       if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sss", $nombre, $apellido, $email, $cargo, $contrasenia);

        if ($stmt->execute()) {
            echo "usuario editado correctamente";
            exit();
        }else{
            echo "error al editar ejercicio 1: ". $stmt->error;
        }
        
    }else{
            echo "error al editar ejercicio 1: ".$query."<br>". $conexion->error;
    }
}