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
