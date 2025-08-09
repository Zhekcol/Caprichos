<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

include_once __DIR__ . '/../includes/header.php';

$usuarioId = $_SESSION['usuario_id'];
?>
<!--Falta: inventario sin stock, lo reservado, El nuevo producto, control de usuarios-->
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-12">
            <h2 class="text-center">PEDIDOS RESERVADOS</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr class='text-center align-middle'>
                            <th scope="col"># PEDIDO</th>
                            <th scope="col">FECHA PEDIDO</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">TELEFONO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">TOTAL PEDIDO</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener todos los productos del inventario
                        $sql = "SELECT id_pedido,
                        id_cliente,
                        cliente,
                        email,
                        telefono,
                        direccion,
                        fecha_pedido,
                        total
                    FROM vista_pedidos_reservados;";

                        $pedidos = executeQuery($mysqli, $sql)->get_result();

                        $total_pedidos = 0;

                        while ($pedido = $pedidos->fetch_assoc()) {
                            $total_pedidos += $pedido['total'] ?? 0;

                            echo "
                <tr class='text-center'>
                    <td>{$pedido['id_pedido']}</td>
                    <td>{$pedido['fecha_pedido']}</td>
                    <td>{$pedido['cliente']}</td>
                    <td>{$pedido['email']}</td>
                    <td>{$pedido['telefono']}</td>
                    <td>{$pedido['direccion']}</td>
                    <td>" . number_format($pedido['total'], 2, '.', ',') . "</td>
                    <td>
                        <a href='detalle_pedido.php?id_pedido={$pedido['id_pedido']}&id_cliente={$pedido['id_cliente']}' class='btn btn-warning btn-editar w-100 mb-2'>Gestionar Pedido</a>
                    </td>
                </tr>";
                        }

                        // Fila para TOTAL (después del while)
                        echo "
                <tr class='table-bordered'>
                    <td colspan='6' class='text-end'><strong>Total Pedidos -></strong></td>
                    <td colspan='1' class='text-center'><strong>" . number_format($total_pedidos, 2, '.', ',') . "</strong></td>
                    <td colspan='1'</td>
                </tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>