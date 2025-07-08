<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}
// Inicializar el usuario con valores vacíos
$user = [
    'nombre' => '',
    'email' => '',
    'telefono' => '',
    'direccion' => ''
];

// Verificar si el usuario está logueado y obtener sus datos
// Si el usuario está logueado, obtenemos sus datos y los mostramos en el formulario
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
    <form action="procesar_reserva.php" method="POST">

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

        <button type="submit" class="btn btn-warning">Reservar</button>
    </form>
</div>


<?php include '../includes/footer.php'; ?>
