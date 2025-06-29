<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
?>

<div class="container">
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado'): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Producto eliminado con éxito.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12 col-lg-12">
            <h2 class="text-center">CARRITO DE COMPRAS</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">PRODUCTO</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">PRECIO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">TALLA</th>
                            <th scope="col">CANTIDAD</th>
                            <th scope="col">SUBTOTAL</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener el pedido pendiente del usuario
                        $sql = "SELECT id FROM pedidos WHERE usuario_id = ? AND estado = 'pendiente' LIMIT 1";
                        $pedido = executeQuery($mysqli, $sql, [$usuarioId], "i")->get_result()->fetch_assoc();

                        if ($pedido) {
                            // Obtener los productos del carrito
                            $sql = "SELECT p.id, p.nombre, p.precio, p.imagen, dp.cantidad, dp.precio AS subtotal, t.nombre AS talla 
                                    FROM detalles_pedido dp
                                    JOIN productos p ON dp.producto_id = p.id
                                    JOIN tallas t ON dp.talla_id = t.id
                                    WHERE dp.pedido_id = ?";
                            $productos = executeQuery($mysqli, $sql, [$pedido['id']], "i")->get_result();

                            $total = 0; // Inicializamos total

                            while ($producto = $productos->fetch_assoc()) {
                                $total += $producto['subtotal']; // Sumar subtotal de cada producto

                                echo "
                                <tr>
                                    <td><img width='105' src=\"../assets/images/{$producto['imagen']}\" alt=''></td>
                                    <td>{$producto['nombre']}</td>
                                    <td>{$producto['precio']}</td>
                                    <td>" . date('d/m/Y') . "</td>
                                    <td>{$producto['talla']}</td>
                                    <td>{$producto['cantidad']}</td>
                                    <td>" . number_format($producto['subtotal'], 3, '.', ',') . "</td>
                                    <td>
                                        <a href='#' class='btn btn-danger btn-eliminar' data-href='../includes/eliminar_pedido.php?id={$producto['id']}'>Eliminar</a>
                                    </td>
                                </tr>";
                            }

                            // Fila para TOTAL (después del while)
                            echo "
                            <tr class='table-bordered'>
                                <td colspan='6' class='text-end'><strong>Total:</strong></td>
                                <td colspan='1'><strong>$" . number_format($total, 3, '.', ',') . "</strong></td>
                                <td colspan='1'><button type='button' class='btn btn-warning'>Reservar</button></td>
                            </tr>";

                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No hay productos en el carrito.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este producto del carrito?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="#" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</a>
        </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>