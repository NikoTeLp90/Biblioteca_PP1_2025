<?php
// Cambie la ruta a esto porque las relativas no funcionan si esta en php/alumno
$current_dir = dirname(__FILE__);
$config_dir = $current_dir . '/../config/';

include $config_dir . 'config.php';
include $config_dir . 'connect.php';

function crearAlumno($conexion, $nombre, $apellido, $email, $cargo, $contrasenia){
    $query = "INSERT INTO usuarios (nombre, apellido, email, cargo, contrasenia) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query) ){
        $stmt ->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasenia);

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

function obtenerAlumnos($conexion){
    $query = "SELECT * FROM usuarios";
    if ($stmt = $conexion->prepare($query)){
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result;
        }else {
            echo "Error al obtener alumnos: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}


function eliminarAlumno($conexion, $id){
    $query = "DELETE FROM usuarios WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            echo "Alumno eliminado correctamente";
        }else {
            echo "Error al eliminar alumno: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function actualizarAlumno($conexion, $id, $nombre, $apellido, $email, $cargo){
    echo $id;
    $query = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, cargo = ? WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $cargo, $id);
        if($stmt->execute()){
            echo "Alumno actualizado correctamente con el id: " . $id;
        }else {
            echo "Error al actualizar alumno: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function obtenerAlumno($conexion, $id){
    $query = "SELECT * FROM usuarios WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }else {
            echo "Error al obtener alumno: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function obtenerUsuarioByEmail($conexion, $email){
    $query = "SELECT * FROM usuarios WHERE email = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("s", $email);
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }else {
            echo "Error al obtener usuario: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

//DB Functions Insumos

function crearInsumo($conexion, $codigo, $nombre, $categoria, $carrera, $estado, $observaciones){
    $query = "INSERT INTO insumos (codigo, nombre, categoria, carrera, estado, observaciones) VALUES (?,?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query) ){
        $stmt ->bind_param("ssssss", $codigo, $nombre, $categoria, $carrera, $estado, $observaciones);

        if($stmt->execute()){
            echo "Insumo creado correctamente";
            
            exit();
        }else {
            echo "Error al crear insumo: ". $stmt ->error;

        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function obtenerInsumos($conexion){
    $query = "SELECT * FROM insumos";
    if ($stmt = $conexion->prepare($query)){
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result;
        }else {
            echo "Error al obtener insumos: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}


function eliminarInsumo($conexion, $id){
    $query = "DELETE FROM insumos WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            echo "Insumo eliminado correctamente";
        }else {
            echo "Error al eliminar insumo: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function actualizarInsumo($conexion, $id, $nombre, $categoria, $carrera, $estado, $codigo, $observaciones){
    echo $id;
    $query = "UPDATE insumos SET codigo = ?, nombre = ?, categoria = ?, carrera = ?, estado = ?, observaciones = ? WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("ssssssi", $codigo, $nombre, $categoria, $carrera, $estado, $observaciones, $id);
        if($stmt->execute()){
            echo "Insumo actualizado correctamente con el id: " . $id;
        }else {
            echo "Error al actualizar insumo: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}

function obtenerInsumo($conexion, $id){
    $query = "SELECT * FROM insumos WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }else {
            echo "Error al obtener insumo: " . $stmt->error;
        }
    }else {
        echo "Error " . $query . "<br>" . $conexion ->error;
    }
}