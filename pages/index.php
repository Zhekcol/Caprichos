<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// Obtener el género y la categoría desde la URL
$genero = $_GET['genero'] ?? '';
$categoria = $_GET['categoria'] ?? '';

// Si se selecciona un género, obtener los productos de ese género
if (!empty($genero)) {
    if (!empty($categoria)) {
        // Consulta SQL para filtrar productos por género y categoría
        $sql = "
            SELECT p.* 
            FROM productos p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.genero = ? AND c.nombre = ?
        ";
        $stmt = executeQuery($mysqli, $sql, [$genero, $categoria], "ss");
    } else {
        // Si solo se selecciona un género, obtener todos los productos de ese género
        $sql = "SELECT * FROM productos WHERE genero = ?";
        $stmt = executeQuery($mysqli, $sql, [$genero], "s");
    }

    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Si no hay filtro, obtener todos los productos por defecto
    $sql = "SELECT * FROM productos";
    $stmt = executeQuery($mysqli, $sql);
    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Limpiar la sesión después de usarla
unset($_SESSION['productos_filtrados']);
unset($_SESSION['filtrado_realizado']);

// Filtrar los productos por género
$productosHombres = array_filter($productos, fn($p) => $p['genero'] === 'Hombre');
$productosMujeres = array_filter($productos, fn($p) => $p['genero'] === 'Mujer');
$productosAccesorios = array_filter($productos, fn($p) => $p['genero'] === 'Accesorio');
?>

<!-- Catálogo Hombres -->
<div class="container contenido-hombres" id="hombres">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <?php foreach ($productosHombres as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 3, '.', ''); ?>$</p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Catálogo Mujeres -->
<div class="container contenido-mujeres" id="mujeres">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <?php foreach ($productosMujeres as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 3, '.', ''); ?>$</p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Catálogo Accesorios -->
<div class="container contenido-accesorios" id="accesorios">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <?php foreach ($productosAccesorios as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 3, '.', ''); ?>$</p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<?php include '../includes/footer.php'; ?>