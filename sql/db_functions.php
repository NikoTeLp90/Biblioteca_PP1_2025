<?php

// include '../config/config.php';
// include '../config/config.php';
require '../config/connect.php';
require '../config/connect.php';

function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "INSERT INTO usuario (nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) { 
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena); // bindear (apunta) para asegurar que los elementos sean los correctos "sss" es string-string-string
    
        if ($stmt->execute()) {
            echo "Usuario creado correctamente";

            exit();
        } else {
            echo "Error al crear usuario: ". $stmt->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
}



function editarAlumno($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, dni = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssi", $nombre, $apellido, $email, $cargo, $contrasena, $id);

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
    $sql = "SELECT * FROM usuario";
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

    $sql = "DELETE FROM usuario WHERE id = ?";
    
    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Usuario eliminado correctamente";
        } else {
            echo "Error al eliminar usuario: " . $stmt->error;
        }
        
        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

?>
