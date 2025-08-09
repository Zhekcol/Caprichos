<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Solo administradores
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nuevoRol = isset($_GET['rol']) ? $_GET['rol'] : '';

$rolesPermitidos = ['admin', 'cliente', 'user'];

if ($id > 0 && in_array($nuevoRol, $rolesPermitidos)) {
    $stmt = $mysqli->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
    $stmt->bind_param('si', $nuevoRol, $id);
    $stmt->execute();
}

header('Location: ../admin/usuarios.php');
exit();
