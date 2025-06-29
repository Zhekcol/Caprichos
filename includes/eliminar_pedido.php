<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$productoId = $_GET['id'] ?? null;

if ($productoId === null) {
    die("ID de producto no proporcionado.");
}

// Obtener el pedido pendiente del usuario
$sql = "SELECT id FROM pedidos WHERE usuario_id = ? AND estado = 'pendiente' LIMIT 1";
$pedido = executeQuery($mysqli, $sql, [$usuarioId], "i")->get_result()->fetch_assoc();

if ($pedido) {
    // Eliminar el producto del pedido
    $sql = "DELETE FROM detalles_pedido WHERE pedido_id = ? AND producto_id = ?";
    executeQuery($mysqli, $sql, [$pedido['id'], $productoId], "ii");
}

// Verificar si quedan más productos en el pedido
$sql = "SELECT COUNT(*) as total FROM detalles_pedido WHERE pedido_id = ?";
$resultado = executeQuery($mysqli, $sql, [$pedido['id']], "i")->get_result()->fetch_assoc();

if ($resultado['total'] == 0) {
    // Eliminar el pedido
    $sql = "DELETE FROM pedidos WHERE id = ?";
    executeQuery($mysqli, $sql, [$pedido['id']], "i");
}

header("Location: ../pages/carrito.php?mensaje=eliminado");
exit();
