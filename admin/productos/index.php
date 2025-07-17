<?php 
session_start();

if ((!isset($_SESSION['usuario_id'])) && ($_SESSION['usuario_rol'] !== "admin")) {
    header("Location: ../../pages/login.php");
    exit;
}
//Se deben llamar estos archivos para las funciones y la conexión a la db para la variable mysqli
include_once '../../includes/db.php';
include_once '../../includes/filtrosProductos.php';

// 1. Obtener valores de la URL (por defecto 'Hombre' si no hay)
$genero = $_GET['genero'] ?? '';
$categoria = $_GET['categoria'] ?? '';

// 2. Obtener y clasificar productos
$productos = obtenerProductos($mysqli, $genero, $categoria);
$clasificados = clasificarProductosPorGenero($productos);

// 3. Obtener categorías por género (necesario para el header)
$categoriasPorGenero = [];
foreach (['Hombre', 'Mujer', 'Accesorio'] as $g) {
    $categoriasPorGenero[$g] = obtenerCategoriasPorGenero($mysqli, $g);
}

//Se define sección para automatizar los enlaces del header
define('SECCION_ACTUAL', 'admin');
// 4. Incluir el header, ya con las variables listas
include '../../includes/header.php';

?>

<!-- Catálogo Hombres -->
<div class="container contenido-hombres" id="hombres">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <?php foreach ($clasificados['Hombre'] as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 2, '.', ''); ?>$</p>
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
        <?php foreach ($clasificados['Mujer'] as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 2, '.', ''); ?>$</p>
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
        <?php foreach ($clasificados['Accesorio'] as $producto) { ?>
            <div class="col mb-4">
                <div class="card border-light">
                    <a href="./productos.php?id=<?= $producto['id']; ?>&categoria_id=<?= $producto['categoria_id']; ?>" class="text-decoration-none text-dark align-items-start">
                        <img src="<?= BASE_URL ?>assets/images/<?= $producto['imagen']; ?>" alt="" class="img-fluid">
                        <div class="card-body text-start px-0">
                            <h1 class="h5 card-title"><?= $producto['nombre']; ?></h1>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <p class="card-text"><?= number_format($producto['precio'], 2, '.', ''); ?>$</p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<?php include '../../includes/footer.php'; ?>

