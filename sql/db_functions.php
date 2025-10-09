<?php

include '../config/config.php';
include '../config/connect.php';

function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena){
    $query = "INSERT INTO usuario(nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";
function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena){
    $query = "INSERT INTO usuario(nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena);
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena);

    
        if($stmt->execute()){
            $msg = "Usuario creado correctamente";
            // Mostrar mensaje al usuario y redirigir a la lista
            echo "<script>alert(" . json_encode($msg) . "); window.location.href = 'listar_alumnos.php';</script>";
            exit();
        } else {
            $err = "Error al crear usuario: " . $stmt->error;
            // Mostrar mensaje de error y volver al formulario de alta
            echo "<script>alert(" . json_encode($err) . "); window.location.href = 'agregar_alumno.php';</script>";
            exit();
        }
    } else {
        $err = "Error: " . $query . " - " . $conexion->error;
        echo "<script>alert(" . json_encode($err) . "); window.location.href = 'agregar_alumno.php';</script>";
    }
}



function editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, cargo = ?, contrasena = ? WHERE id = ?";
function editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, cargo = ?, contrasena = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $cargo, $contrasena, $id);
        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $cargo, $contrasena, $id);

        if ($stmt->execute()) {
            echo "Usuario actualizado correctamente";
            echo "Usuario actualizado correctamente";
            // Opcional: redirigir a la lista de alumnos
            header("Location: listar_alumnos.php");
            exit();
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
            echo "Error al actualizar el usuario: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}


function obtenerUsuarios($conexion): array {
    $sql = "SELECT * FROM usuario";
    $result = $conexion->query($sql);

    if (!$result) {
        // Mostrar error para depurar
        die("Error en la consulta SQL: " . $conexion->error);
    }

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
$sqlFicha = "DELETE FROM usuario WHERE id = ?";
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
// INSUMOS ------------------------

function agregarInsumo($conexion, $nombre, $categoria, $disponibilidad, $estado, $observaciones) {
    $query = "INSERT INTO insumo (nombre, categoria, disponibilidad, estado, observaciones) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssss", $nombre, $categoria, $disponibilidad, $estado, $observaciones); // bindear (apunta) para asegurar que los elementos sean los correctos "sss" es string-string-string

        if ($stmt->execute()) {
            echo "Insumo cargado correctamente";
            echo '<br>';
            echo '<a href="../index.html">Ir al Index</button>';
            echo '<br>';
            echo '<a href="listar_insumos.php">Ver insumos</a>';
            exit();
        } else {
            echo "Error al cargar insumo: ". $stmt->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
}

function editarInsumo($conexion, $id, $nombre, $categoria, $disponibilidad, $estado, $observaciones) {
    $query = "UPDATE insumo SET nombre = ?, categoria = ?, disponibilidad = ?, estado = ?, observaciones = ? WHERE id = ?;";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssssi", $nombre, $categoria, $disponibilidad, $estado, $observaciones, $id);

        if ($stmt->execute()) {
            echo "Insumo actualizado correctamente";
            // Opcional: redirigir a la lista de alumnos
            header("Location: listar_insumos.php");
            exit();
        } else {
            echo "Error al actualizar insumo: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

function obtenerInsumos($conexion): array {
    $sql = "SELECT * FROM insumo;";
    $result = $conexion ->query($sql);
    $insumos = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $insumos[] = $row;
        }
    }
    return $insumos;
}

function eliminarInsumo($conexion, $id) {

    $sql = "DELETE FROM insumo WHERE id = ?;";

    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Insumo eliminado correctamente";
        } else {
            echo "Error al eliminar insumo: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

?>