<?php
include '../config/config.php';
include '../config/connect.php';

function crearAlumno($conexion, $nombre, $apellido, $dni){
    $query = "INSERT INTO alumnos (nombre, apellido, dni) VALUES (?,?,?)";

    if ($stmt = $conexion->prepare($query) ){
        $stmt ->bind_param("sss", $nombre, $apellido, $dni);

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
    $query = "SELECT * FROM alumnos";
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
    $query = "DELETE FROM alumnos WHERE id = ?";
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

function actualizarAlumno($conexion, $id, $nombre, $apellido, $dni){
    echo $id;
    $query = "UPDATE alumnos SET nombre = ?, apellido = ?, dni = ? WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id);
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
    $query = "SELECT * FROM alumnos WHERE id = ?";
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
