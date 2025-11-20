<?php

require '../../config/connect.php';
require '../../sql/db_functions.php';

session_start();

// INMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener arrays de nombres y observaciones
    $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : [];
    $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : [];
    
    // Valores por defecto para nuevo insumo
    $categoria = 'otro'; // Valor por defecto
    $disponibilidad = 'disponible'; // Siempre disponible al crear
    $estado = 'disponible'; // Siempre disponible al crear

    $exitosos = 0;
    $errores = 0;

    // Procesar cada insumo
    if (is_array($nombres) && count($nombres) > 0) {
        foreach ($nombres as $index => $nombre) {
            $nombre = trim($nombre);
            if (empty($nombre)) {
                $errores++;
                continue;
            }
            
            // Obtener la observación correspondiente (puede estar vacía)
            $observacion = isset($observaciones[$index]) ? trim($observaciones[$index]) : '';
            
            if (agregarInsumo($conexion, $nombre, $categoria, $disponibilidad, $estado, $observacion)) {
                $exitosos++;
            } else {
                $errores++;
            }
        }
    } else {
        // Fallback: si no vienen como array, usar el método anterior
        $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : '';
        $cantidad = isset($_POST["cantidad"]) ? (int)$_POST["cantidad"] : 1;
        $observaciones_text = isset($_POST["observaciones"]) ? trim($_POST["observaciones"]) : '';
        
        if (!empty($nombre)) {
            for ($i = 0; $i < $cantidad; $i++) {
                if (agregarInsumo($conexion, $nombre, $categoria, $disponibilidad, $estado, $observaciones_text)) {
                    $exitosos++;
                } else {
                    $errores++;
                }
            }
        }
    }

    if ($exitosos > 0) {
        if ($errores == 0) {
            $mensaje = "Se agregaron correctamente $exitosos insumo(s)";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Se agregaron $exitosos insumo(s) correctamente, pero hubo $errores error(es)";
            $tipo_mensaje = "warning";
        }
    } else {
        $mensaje = "No se pudo agregar ningún insumo. Verifique que los nombres no estén vacíos.";
        $tipo_mensaje = "danger";
    }
    
    header("Location: listar_insumos.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo_mensaje);
    exit();
} else {
    header("Location: listar_insumos.php");
    exit();
}
