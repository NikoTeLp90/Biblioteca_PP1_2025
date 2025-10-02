<?php

include '../config/config.php';
include '../config/connect.php';

function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena){
    $query = "INSERT INTO usuario(nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena);

    
        if($stmt->execute()){
            echo "Usuario creado correctamente";

            exit();
        } else {
            echo "Error al crear usuario: ". $stmt->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
}



function editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, cargo = ?, contrasena = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $cargo, $contrasena, $id);

        if ($stmt->execute()) {
            echo "Usuario actualizado correctamente";
            // Opcional: redirigir a la lista de alumnos
            header("Location: listar_alumnos.php");
            exit();
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
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