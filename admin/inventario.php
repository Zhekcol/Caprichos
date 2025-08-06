<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
include_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
?>
<!--Falta: inventario sin stock, lo reservado, El nuevo producto, control de usuarios-->
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-12">
      <h2 class="text-center">INVENTARIO</h2>
      <div class="text-center my-3"> <!--<div class="d-flex justify-content-center flex-wrap gap-2">-->
        <a href="editar_productos.php" class="btn btn-outline-success me-2">Agregar Nuevo Producto</a><!--El outline es para botones sin color de fondo-->
        <a href="productos_sin_stock.php" class="btn btn-outline-danger me-2">Productos sin Stock</a>
        <a href="pedidos_reserva.php" class="btn btn-outline-primary me-2">Pedidos en Reserva</a>
        <a href="usuarios.php" class="btn btn-outline-dark me-2">Control de Usuarios</a>
        <a href="<?= BASE_URL . 'includes/informe_pedidos.php'?>" class="btn btn-outline-info">Informe de Pedidos</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="table-responsive mt-4">
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr class='text-center align-middle'>
              <th scope="col">PRODUCTO</th>
              <th scope="col">GENERO</th>
              <th scope="col">CATEGORIA</th>
              <th scope="col">DETALLE</th>
              <th scope="col">TALLAS</th>
              <th scope="col">STOCK</th>
              <th scope="col">RESERVADO</th>
              <th scope="col">PRECIO UNIDAD</th>
              <th scope="col">ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Obtener todos los productos del inventario
              $sql = "SELECT id,
                        genero,
                        categoria,
                        nombre,
                        precio,
                        imagen,
                        tallas,
                        total_stock,
                        total_reservado
                      FROM vista_inventario_productos";
              $productos = executeQuery($mysqli, $sql)->get_result();

              $stock = 0; // Inicializamos stock
              $reservado = 0; // Inicializamos reservado

              while ($producto = $productos->fetch_assoc()) {
                $stock += $producto['total_stock'];
                $reservado += $producto['total_reservado'];

                echo "
                <tr class='text-center'>
                  <td><img width='105' src=\"../assets/images/{$producto['imagen']}\" alt=''></td>
                  <td>{$producto['genero']}</td>
                  <td>{$producto['categoria']}</td>
                  <td>{$producto['nombre']}</td>
                  <td>{$producto['tallas']}</td>
                  <td>{$producto['total_stock']}</td>
                  <td>{$producto['total_reservado']}</td>
                  <td>" . number_format($producto['precio'], 2, '.', ',') . "</td>
                  <td>
                    <a href='editar_productos.php?id={$producto['id']}' class='btn btn-warning btn-editar w-100 mb-2'>Editar Detalles</a>
                    <!--<a href='#' class='btn btn-info btn-info w-100'>Ver Reservas</a>-->
                  </td>
                </tr>";
              }

              // Fila para TOTAL (después del while)
              echo "
              <tr class='table-bordered'>
                <td colspan='5' class='text-end'><strong>Total Stock -></strong></td>
                <td colspan='1' class='text-center'><strong>$stock</strong></td>
                <td colspan='1' class='text-center'><strong>$reservado</strong></td>
                <td colspan='2' class='text-start'><strong><- Total Reservado</strong></td>
              </tr>";
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>