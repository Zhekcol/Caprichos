<?php
// pages/reserva.php
session_start();

// Inclusión segura de archivos
require_once __DIR__ . '/../includes/db.php';
include_once __DIR__ . '/../includes/header.php';
/*
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}*/

// Verificar sesión solo al procesar el formulario, no al mostrar la página
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['usuario_id'])) {
    header('Location: login.php?redirect=reserva');
    exit();
}

// Obtener datos del producto y talla desde la URL
$producto_id = $_GET['producto_id'] ?? '';
$talla = $_GET['talla'] ?? '';

if (empty($producto_id)) {
    die("No se ha seleccionado ningún producto para reservar.");
}

// Obtener información del producto
try {
    $sql = "SELECT p.*, c.nombre AS categoria_nombre 
            FROM productos p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.id = ?";
    $stmt = executeQuery($mysqli, $sql, [$producto_id], "i");
    $producto = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if (!$producto) {
        throw new Exception("Producto no encontrado");
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// Obtener datos del usuario
$user = [
    'nombre' => '',
    'email' => '',
    'telefono' => '',
    'direccion' => ''
];

if (isset($_SESSION['usuario_id'])) {
    $sql = "SELECT nombre, email, telefono, direccion FROM usuarios WHERE id = ?";
    $stmt = executeQuery($mysqli, $sql, [$_SESSION['usuario_id']], 'i');
    $stmt->bind_result($user['nombre'], $user['email'], $user['telefono'], $user['direccion']);
    $stmt->fetch();
    $stmt->close();
}
?>

<!-- Formulario de reserva-->
<div class="container mt-5">
    <h2 class="mb-4">Formulario de Reserva</h2>
    
    <!-- Mostrar información del producto -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
            <p class="card-text">
                <strong>Categoría:</strong> <?= htmlspecialchars($producto['categoria_nombre']) ?><br>
                <strong>Género:</strong> <?= htmlspecialchars($producto['genero']) ?><br>
                <strong>Talla seleccionada:</strong> <?= htmlspecialchars($talla) ?><br>
                <strong>Precio:</strong> $<?= number_format($producto['precio'], 3, '.', '') ?>
            </p>
        </div>
    </div>
    
    <form action="procesar_reserva.php" method="POST">
        <!-- Campos ocultos con la información del producto -->
        <input type="hidden" name="producto_id" value="<?= htmlspecialchars($producto_id) ?>">
        <input type="hidden" name="talla" value="<?= htmlspecialchars($talla) ?>">

        <div class="mb-3"> <!-- Campo de nombre -->
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                class="form-control <?= isset($_SESSION['usuario_id']) ? 'bg-light shadow-sm' : '' ?>"
                value="<?= htmlspecialchars($user['nombre']) ?>"
                <?= isset($_SESSION['usuario_id']) ? 'readonly' : '' ?> required>
        </div>

        <div class="mb-3"> <!-- Campo de correo electrónico -->
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email"
                class="form-control <?= isset($_SESSION['usuario_id']) ? 'bg-light shadow-sm' : '' ?>"
                value="<?= htmlspecialchars($user['email']) ?>"
                <?= isset($_SESSION['usuario_id']) ? 'readonly' : '' ?> required>
        </div>

        <div class="mb-3"> <!-- Campo de teléfono -->
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control"
                value="<?= isset($user['telefono']) ? htmlspecialchars($user['telefono']) : '' ?>"
                maxlength="10" pattern="\d{10}" inputmode="numeric"
                title="Debe contener exactamente 10 números" required>
        </div>

        <div class="mb-3"> <!-- Campo de dirección -->
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control"
                value="<?= isset($user['direccion']) ? htmlspecialchars($user['direccion']) : '' ?>"
                required>
        </div>

        <button type="submit" class="btn btn-warning">Confirmar Reserva</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
