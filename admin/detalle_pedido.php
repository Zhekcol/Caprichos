<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

include_once __DIR__ . '/../includes/header.php';

// Validar parámetros
$id_pedido = isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 0;
$id_cliente = isset($_GET['id_cliente']) ? intval($_GET['id_cliente']) : 0;

if ($id_pedido === 0 || $id_cliente === 0) {
    echo "<div class='alert alert-danger text-center'>Parámetros inválidos.</div>";
    include_once __DIR__ . '/../includes/footer.php';
    exit();
}

// 1. Obtener datos del cliente
$sql_cliente = "
    SELECT id, nombre AS cliente, email, telefono, direccion
    FROM usuarios
    WHERE id = $id_cliente;
";
$cliente = executeQuery($mysqli, $sql_cliente)->get_result()->fetch_assoc();

// 2. Obtener detalles del pedido
$sql_detalles = "
    SELECT pedido_id,
        usuario_id,
        fecha_pedido,
        imagen,
        detalle,
        talla,
        cantidad,
        precio_unidad,
        subtotal
    FROM vista_detalles_pedido
    WHERE pedido_id = $id_pedido AND usuario_id = $id_cliente;
";
$detalles = executeQuery($mysqli, $sql_detalles)->get_result();

$total_pedido = 0;
?>

<div class="container">
    <!-- Botón para volver -->
    <div class="mt-3 mb-3">
        <a href="pedidos_reserva.php" class="btn btn-secondary">← Volver a Pedidos Reservados</a>
    </div>

    <!-- Tabla Cliente -->
    <h3>Datos del Cliente</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Cliente</th>
                    <td><?= htmlspecialchars($cliente['cliente']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tabla Detalles Pedido -->
    <h3>Detalles del Pedido #<?= $id_pedido ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>Fecha Pedido</th>
                    <th>Producto</th>
                    <th>Detalle</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Precio Unidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $detalles->fetch_assoc()):
                    $total_pedido += $item['subtotal'];
                    ?>
                    <tr class="text-center align-middle">
                        <td><?= $item['fecha_pedido'] ?></td>
                        <td>
                            <img src="<?= htmlspecialchars('../assets/images/' . $item['imagen'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="Producto" width="105">
                        </td>
                        <td><?= htmlspecialchars($item['detalle']) ?></td>
                        <td><?= htmlspecialchars($item['talla']) ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td><?= number_format($item['precio_unidad'], 2, '.', ',') ?></td>
                        <td><?= number_format($item['subtotal'], 2, '.', ',') ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="table-bordered">
                    <td colspan="6" class="text-end"><strong>Total Pedido -></strong></td>
                    <td class="text-center"><strong><?= number_format($total_pedido, 2, '.', ',') ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Botones de Acción -->
    <div class="mt-4 d-flex gap-3">
        <a href="#" class="btn btn-success btn-accion" data-href="../includes/completar_pedido.php?id=<?= $id_pedido ?>"
            data-titulo="Confirmar completado" data-mensaje="¿Estás seguro de marcar este pedido como completado?">
            Completado
        </a>

        <a href="#" class="btn btn-danger btn-accion" data-href="../includes/cancelar_pedido.php?id=<?= $id_pedido ?>"
            data-titulo="Confirmar cancelación"
            data-mensaje="¿Estás seguro de cancelar este pedido? Esta acción no se puede deshacer.">
            Cancelado
        </a>
    </div>
</div>
<!-- Modal de confirmación -->
<div class="modal fade" id="modalAccion" tabindex="-1" aria-labelledby="modalAccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalAccionLabel">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalAccionMensaje">
                <!-- Aquí se pondrá el mensaje dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-primary" id="btnConfirmarAccion">Aceptar</a>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>