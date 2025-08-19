<?php

include '../config/config.php';
include '../config/connect.php';

function crearAlumno($conexion, $nombre, $apellido, $dni){
    $query = "INSERT INTO alumnos (nombre, apellido, dni) VALUES (?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sss", $nombre, $apellido, $dni);

    
        if($stmt->execute()){
            echo "Alumno creado correctamente";

            exit();
        } else {
            echo "Error al crear alumno: ". $stmt->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
}



function editarAlumno($conexion, $id, $nombre, $apellido, $dni) {
    $query = "UPDATE alumnos SET nombre = ?, apellido = ?, dni = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssi", $nombre, $apellido, $dni, $id);

        if ($stmt->execute()) {
            echo "Alumno actualizado correctamente";
            // Opcional: redirigir a la lista de alumnos
            header("Location: listar_alumnos.php");
            exit();
        } else {
            echo "Error al actualizar el alumno: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}


function obtenerAlumnos($conexion): array {
    $sql = "SELECT * FROM alumnos";
    $result = $conexion ->query($sql);
    $alumnos = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $alumnos[] = $row;
        }
    }
    return $alumnos;
}

function eliminarAlumno($conexion, $id) {
// Primero, elimina los registros relacionados en ficha_medica
$sqlFicha = "DELETE FROM alumnos WHERE id = ?";
if ($stmtFicha = $conexion->prepare($sqlFicha)) {
    $stmtFicha->bind_param("i", $id);
    $stmtFicha->execute();
    $stmtFicha->close();
    }

    $sql = "DELETE FROM alumnos WHERE id = ?";
    
    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "alumno eliminada correctamente";
        } else {
            echo "Error al eliminar alumno: " . $stmt->error;
        }
        
        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

?>