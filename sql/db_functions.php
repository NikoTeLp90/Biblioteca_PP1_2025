<?php

// Incluir archivos de configuración usando rutas absolutas basadas en este archivo
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/connect.php';

$GLOBALS['constantes'] = [
    'disponible' => 'Disponible',
    'en_reparacion' => 'En Reparación',
    'fuera_servicio' => 'Fuera de Servicio',
    'en_prestamo' => 'En Préstamo',
    'baja' => 'Dado de Baja',
    'tecnologia' => 'Tecnología',
    'bibliografia' => 'Bibliografía',
    'electrico' => 'Eléctrico',
    'otro' => 'Otro'
];

// Función para obtener la etiqueta
function getEtiqueta($clave) {
    return $GLOBALS['constantes'][$clave] ?? 'Desconocido';
}

function getClave($etiqueta) {
    return array_search($etiqueta, $GLOBALS['constantes']) ?? '';
}


//Funciones para crear, editar, eliminar y obtener usuarios
function crearUsuario($conexion, $nombre, $apellido, $dni, $email, $cargo, $contrasenia){
    $query = "INSERT INTO usuario(nombre, apellido, dni, email, cargo, contrasenia) VALUES (?,?,?,?,?,?)";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("ssssss", $nombre, $apellido, $dni, $email, $cargo, $contrasenia);
        try {
            if ($stmt->execute()) {
                $msg = "Usuario creado correctamente";
                // Mostrar mensaje al usuario y redirigir a la lista
                echo "<script>alert(" . json_encode($msg) . "); window.location.href = 'listar_alumnos.php';</script>";
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            // Manejar clave duplicada (dni o email único)
            if ($e->getCode() === 1062) {
                $err = "Ya existe un usuario con ese DNI o email.";
            } else {
                $err = "Error al crear usuario: " . $e->getMessage();
            }
            // Mostrar mensaje de error y volver al formulario de alta
            echo "<script>alert(" . json_encode($err) . "); window.location.href = 'agregar_alumno.php';</script>";
            exit();
        }
    } else {
        $err = "Error: " . $query . " - " . $conexion->error;
        echo "<script>alert(" . json_encode($err) . "); window.location.href = 'agregar_alumno.php';</script>";
    }
}



function editarUsuario($conexion, $id, $nombre, $apellido, $dni, $email, $cargo) {
    $query = "UPDATE usuario SET nombre = ?, apellido = ?, dni = ?, email = ?, cargo = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("sssssi", $nombre, $apellido, $dni, $email, $cargo, $id);


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

function obtenerUsuarioPorDni($conexion, $dni){
    $query = "SELECT * FROM usuario WHERE dni = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("s", $dni);
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

function obtenerUsuarioPorId($conexion, $id){
    $query = "SELECT * FROM usuario WHERE id = ?";
    if ($stmt = $conexion->prepare($query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
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

function eliminarUsuario($conexion, $id) {
    $sql = "DELETE FROM usuario WHERE id = ?";
    
    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "usuario eliminada correctamente";
        } else {
            echo "Error al eliminar usuario: " . $stmt->error;
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
        $stmt->bind_param("sssss", $nombre, $categoria, $disponibilidad, $estado, $observaciones); // bindear (apunta) para asegurar que los elementos sean los correctos "sssss" es string-string-string-string-string

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        return false;
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
            $row['disponibilidad'] = getEtiqueta($row['disponibilidad']);
            $row['estado'] = getEtiqueta($row['estado']);
            $row['categoria'] = getEtiqueta($row['categoria']);
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

// PRESTAMOS ------------------------
function agregarPrestamo($conexion, $insumo_id, $destinatario, $fecha_limite, $observacion) {
    // Intento 1: insertar con columna observacion (si existe)
    $queryConObs = "INSERT INTO prestamo (insumo_id, destinatario, fecha_limite, observacion) VALUES (?,?,?,?)";
    $stmt = $conexion->prepare($queryConObs);

    if ($stmt) {
        $stmt->bind_param("isss", $insumo_id, $destinatario, $fecha_limite, $observacion);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        // Si falla, verificamos si es por columna desconocida y probamos sin observacion
        $errno = $stmt->errno;
        $err = $stmt->error;
        $stmt->close();
        if ($errno === 1054 || stripos($err, 'Unknown column') !== false) {
            // Intento 2: insertar sin columna observacion
            $querySinObs = "INSERT INTO prestamo (insumo_id, destinatario, fecha_limite) VALUES (?,?,?)";
            if ($stmt2 = $conexion->prepare($querySinObs)) {
                $stmt2->bind_param("iss", $insumo_id, $destinatario, $fecha_limite);
                if ($stmt2->execute()) {
                    $stmt2->close();
                    return true;
                } else {
                    error_log('Error INSERT prestamo (sin observacion): ' . $stmt2->error . ' | SQL: ' . $querySinObs);
                    $stmt2->close();
                    return false;
                }
            } else {
                error_log('Error prepare prestamo (sin observacion): ' . $conexion->error . ' | SQL: ' . $querySinObs);
                return false;
            }
        } else {
            error_log('Error INSERT prestamo: ' . $err . ' | SQL: ' . $queryConObs);
            return false;
        }
    } else {
        // Si no se puede preparar, probamos directamente sin observacion
        error_log('Error prepare prestamo: ' . $conexion->error . ' | SQL: ' . $queryConObs);
        $querySinObs = "INSERT INTO prestamo (insumo_id, destinatario, fecha_limite) VALUES (?,?,?)";
        if ($stmt2 = $conexion->prepare($querySinObs)) {
            $stmt2->bind_param("iss", $insumo_id, $destinatario, $fecha_limite);
            if ($stmt2->execute()) {
                $stmt2->close();
                return true;
            } else {
                error_log('Error INSERT prestamo (sin observacion): ' . $stmt2->error . ' | SQL: ' . $querySinObs);
                $stmt2->close();
                return false;
            }
        } else {
            error_log('Error prepare prestamo (sin observacion): ' . $conexion->error . ' | SQL: ' . $querySinObs);
            return false;
        }
    }
}


function obtenerPrestamos($conexion): array {
    // ... existing code ...
    $sql = "SELECT 
                p.id,
                p.insumo_id,
                p.destinatario,
                p.fecha_prestamo,
                p.fecha_limite,
                i.nombre AS insumo_nombre
            FROM prestamo p
            LEFT JOIN insumo i ON i.id = p.insumo_id;";
    $result = $conexion->query($sql);


    $prestamos = [];
    while ($row = $result->fetch_assoc()) {
        $prestamos[] = $row;
    }
    return $prestamos;
}
?>