<?php
// pages/index.php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <div class="container p-4">
        <h1>Bienvenido</h1>
        <a href="../pages/logout.php" class="btn btn-outline-dark">Cerrar sesión</a>
    </div>
</body>
</html>