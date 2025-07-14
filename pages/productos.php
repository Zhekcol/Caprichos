<?php
// pages/productos.php
session_start();
// include '../includes/db.php';
include '../includes/header.php';
/*
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}*/

$idProducto = $_GET['id'] ?? '';
$idCategoria = $_GET['categoria_id'] ?? '';

if (!empty($idProducto) && !empty($idCategoria)) {
    //Consulta para obtener el producto seleccionado y su categoria
    $sql = "SELECT p.*, c.nombre AS categoria_nombre 
            FROM productos p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.id = ? AND p.categoria_id = ?;
            ";
    $stmt = executeQuery($mysqli, $sql, [$idProducto, $idCategoria], "ii");
    $producto = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}


if (!empty($idProducto)) {
    // Consulta SQL para obtener las tallas disponibles
    $sql = "
        SELECT t.nombre AS talla
        FROM producto_talla pt
        JOIN tallas t ON pt.talla_id = t.id
        WHERE pt.producto_id = ? AND pt.stock > 0
    ";

    // Preparar y ejecutar la consulta
    $stmt = executeQuery($mysqli, $sql, [$idProducto], "i");
    $resultado = $stmt->get_result();

    // Obtener las tallas disponibles
    $tallas_disponibles = [];
    while ($fila = $resultado->fetch_assoc()) {
        $tallas_disponibles[] = $fila['talla'];
    }

    // Cerrar la consulta
    $stmt->close();
}
?>

<div class="container">
    <div class="row">
        <!-- Columnas para pantallas grandes (lg) -->
        <div class="col-lg-1 d-none d-lg-block"></div>
        <div class="col-lg-6 d-none d-lg-block">
            <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid rounded">
        </div>
        <div class="col-lg-4 d-none d-lg-block">
            <!-- Contenido detalles (versión desktop) -->
            <h1 class="h2"><?= $producto['nombre']; ?></h1>
            <p class="text-muted h5"><?= $producto['categoria_nombre'] . " - " . $producto['genero']; ?></p>
            <h1 class="h4"><?= number_format($producto['precio'], 2, '.', ''); ?>$</h1>
            <br><br>
            <h1 class="h5">Tallas disponibles:</h1>
            <?php foreach ($tallas_disponibles as $key => $talla) { ?>
                <button class="btn btn-outline-dark mb-2 <?= in_array($talla, $tallas_disponibles) ? 'bTalla' : 'text-muted disabled'; ?>" 
                        data-talla="<?= $talla; ?>" <?= !in_array($talla, $tallas_disponibles) ? 'disabled' : ''; ?>>
                    <?= $talla; ?>
                </button>
            <?php } ?>
            <div class="mt-2 mb-2">
                <button type="button" class="agregarCarrito w-100 d-lg-block agregar-carrito <?= !isset($_SESSION['usuario_id']) ? 'no-sesion' : '' ?>" 
                                        data-id="<?= $producto['id']; ?>" 
                                        data-talla="">
                                        AGREGAR AL CARRITO
                </button>
            </div>
            <div class="mt-2 mb-2">
                <button type="button" class="reservar w-100 clic-reservar"
                        data-id="<?= $producto['id']; ?>" 
                        data-talla="">
                        RESERVAR
                </button>
            </div>
            <!-- Contenedor para la alerta de Bootstrap (inicialmente oculto) -->
            <div id="alerta-carrito" class="alert alert-success alert-dismissible fade show mt-3" style="display:none;">
                <strong>¡Éxito!</strong> Producto agregado al carrito.
                <button type="button" class="btn-close" data-dismiss="alert"></button>
            </div>
        </div>
        <div class="col-lg-1 d-none d-lg-block"></div>

        <!-- Versión móvil/tablet (una columna) -->
        <div class="col-12 d-lg-none">
            <!-- Detalles primero -->
            <h1 class="h2"><?= $producto['nombre']; ?></h1>
            <p class="text-muted h5"><?= $producto['categoria_nombre'] . " - " . $producto['genero']; ?></p>
            <h1 class="h4"><?= number_format($producto['precio'], 2, '.', ''); ?>$</h1>
            <br><br>
            <h1 class="h5">Tallas disponibles:</h1>
            <?php foreach ($tallas_disponibles as $key => $talla) { ?>
                <button class="btn btn-outline-dark mb-2 <?= in_array($talla, $tallas_disponibles) ? 'bTalla' : 'text-muted disabled'; ?>" 
                        data-talla="<?= $talla; ?>" <?= !in_array($talla, $tallas_disponibles) ? 'disabled' : ''; ?>>
                    <?= $talla; ?>
                </button>
            <?php } ?>

            <!-- Imagen después -->
            <div class="mt-4">
                <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid rounded">
            </div>

            <!-- Botones al final -->
            <div class="mt-4">
                <a href="" class="agregarCarrito w-100 d-block">AGREGAR AL CARRITO</a>
                <button type="button" class="reservar w-100 mt-2">RESERVAR</button>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>