<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Validar que el usuario sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

// Obtener y validar el ID del pedido
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Cambiar estado a completado
    $stmt = $mysqli->prepare("UPDATE pedidos SET estado = 'completado' WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

// Redirigir de vuelta a la página de pedidos reservados
header('Location: ../admin/pedidos_reserva.php');
exit();
