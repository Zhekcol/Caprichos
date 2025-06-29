<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para agregar productos al carrito.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['producto_id']) || !isset($_POST['talla'])) {
    die("Acceso no válido.");
}

$usuarioId = $_SESSION['usuario_id'];
$productoId = $_POST['producto_id'];
$tallaNombre = $_POST['talla'];

// Validar talla
if (empty($tallaNombre)) {
    die("No se recibió la talla.");
}

// 1. Buscar el ID de la talla por su nombre
$sql = "SELECT id FROM tallas WHERE nombre = ? LIMIT 1";
$stmt = executeQuery($mysqli, $sql, [$tallaNombre], "s");
$result = $stmt->get_result();
$talla = $result->fetch_assoc();
$stmt->close();

if (!$talla) {
    die("La talla no existe.");
}
$tallaId = $talla['id'];

// 2. Verificar si el usuario tiene un pedido "pendiente"
$sql = "SELECT id FROM pedidos WHERE usuario_id = ? AND estado = 'pendiente' LIMIT 1";
$pedido = executeQuery($mysqli, $sql, [$usuarioId], "i")->get_result()->fetch_assoc();

if (!$pedido) {
    $sql = "INSERT INTO pedidos (usuario_id) VALUES (?)";
    $stmt = executeQuery($mysqli, $sql, [$usuarioId], "i");
    $pedidoId = $mysqli->insert_id;
} else {
    $pedidoId = $pedido['id'];
}

// 3. Obtener precio del producto
$sql = "SELECT precio FROM productos WHERE id = ?";
$producto = executeQuery($mysqli, $sql, [$productoId], "i")->get_result()->fetch_assoc();

if (!$producto) {
    die("El producto no existe.");
}

// 4. Verificar si el producto con la talla ya está en el carrito
$sql = "SELECT id, cantidad FROM detalles_pedido 
        WHERE pedido_id = ? AND producto_id = ? AND talla_id = ?";
$detalle = executeQuery($mysqli, $sql, [$pedidoId, $productoId, $tallaId], "iii")->get_result()->fetch_assoc();

// 5. Insertar o actualizar
if ($detalle) {
    $sql = "UPDATE detalles_pedido SET cantidad = cantidad + 1 WHERE id = ?";
    executeQuery($mysqli, $sql, [$detalle['id']], "i");
} else {
    $sql = "INSERT INTO detalles_pedido (pedido_id, producto_id, talla_id, precio, cantidad)
            VALUES (?, ?, ?, ?, 1)";
    executeQuery($mysqli, $sql, [$pedidoId, $productoId, $tallaId, $producto['precio']], "iiid");
}

// 6. Calcular y actualizar el total en la tabla pedidos
$sql = "SELECT SUM(precio * cantidad) AS total FROM detalles_pedido WHERE pedido_id = ?";
$resultado = executeQuery($mysqli, $sql, [$pedidoId], "i")->get_result()->fetch_assoc();
$total = $resultado['total'] ?? 0;

$sql = "UPDATE pedidos SET total = ? WHERE id = ?";
executeQuery($mysqli, $sql, [$total, $pedidoId], "di");

?>
