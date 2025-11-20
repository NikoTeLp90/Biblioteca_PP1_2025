<?php

require '../../sql/db_functions.php';

// session_start();

// // IMPORTANTE PARA QUE NO SE PUEDA ACCEDER A LA PAGINA SI NO ESTA LOGUEADO
// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

// Verificar que se recibieron los parámetros necesarios
if (!isset($_GET['destinatario']) || !isset($_GET['insumos'])) {
    header("Location: ../../index.php");
    exit();
}

$destinatario = trim($_GET['destinatario']);
$insumosIds = explode(',', $_GET['insumos']);

$exitosos = 0;
$errores = 0;

// Procesar cada insumo
foreach ($insumosIds as $insumoId) {
    if (!empty($insumoId)) {
        if (agregarPrestamo($conexion, $insumoId, $destinatario)) {
            $exitosos++;
        } else {
            $errores++;
        }
    }
}

// Redirigir de vuelta con mensaje
if ($errores == 0) {
    $mensaje = "Se crearon $exitosos préstamo(s) correctamente";
    $tipo = "success";
} else {
    $mensaje = "Se crearon $exitosos préstamo(s) correctamente, pero hubo $errores error(es)";
    $tipo = "warning";
}

header("Location: ../../index.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit();

?>
