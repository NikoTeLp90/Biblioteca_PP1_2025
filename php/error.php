<?php
session_start();

$error = $_SESSION['error'] ?? 'Error desconocido';

?>

<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <h1>Ups, algo salió mal</h1>
        <p><?php echo htmlspecialchars($error); ?></p>
        <button onclick="window.location.href='login/login.php'">Volver al login</button>
    </body>
</html>