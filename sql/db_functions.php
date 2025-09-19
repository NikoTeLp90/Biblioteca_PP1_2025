<?php

require '../config/connect.php';
require '../config/connect.php';

function crearUsuario($conexion, $nombre, $apellido, $email, $cargo, $contrasena) {
    $query = "INSERT INTO usuario (nombre, apellido, email, cargo, contrasena) VALUES (?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $cargo, $contrasena); // bindear (apunta) para asegurar que los elementos sean los correctos "sss" es string-string-string

        if ($stmt->execute()) {
            echo "Usuario creado correctamente";
            echo '<br>';
            echo '<a href="../index.html">Ir al Index</button>';
            echo '<br>';
            echo '<a href="listar_usuarios.php">Ver usuarios</a>';
            exit();
        } else {
            echo "Error al crear usuario: ". $stmt->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
}

function editarUsuario($conexion, $id, $nombre, $apellido, $email, $cargo) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, cargo = ? WHERE id = ?;";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $cargo, $id);

        if ($stmt->execute()) {
            echo "Usuario actualizado correctamente";
            // Opcional: redirigir a la lista de alumnos
            header("Location: listar_usuarios.php");
            exit();
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

function obtenerUsuarios($conexion): array {
    $sql = "SELECT * FROM usuario;";
    $result = $conexion ->query($sql);
    $usuarios = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    return $usuarios;
}

function eliminarUsuario($conexion, $id) {

    $sql = "DELETE FROM usuario WHERE id = ?;";

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
