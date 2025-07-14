<?php 
session_start();
include('includes/header.php');

// Conexión a la base de datos y consulta de productos
require_once './includes/db.php';

// Consulta todos los productos
$sql = "SELECT * FROM productos";
$stmt = executeQuery($mysqli, $sql);
$productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Filtrar productos por género
$productosHombres = array_filter($productos, fn($p) => $p['genero'] === 'Hombre');
$productosMujeres = array_filter($productos, fn($p) => $p['genero'] === 'Mujer');
$productosAccesorios = array_filter($productos, fn($p) => $p['genero'] === 'Accesorio');
?>

<!-- Carousel Inicio  -->
<div class="container-fluid p-0 mb-4">
    <div class="carousel slide" id="slider-index" data-bs-ride="carousel">

        <!-- carousel con efecto desbanecido(fade) -->
        <div class="carousel-inner carousel-fade">

            <div class="carousel-item active" data-bs-interval="3000">
                <img class="d-block w-100 image-slider" src="./assets/images/slider/img-slider1.png" alt="" height="600">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>

            <div class="carousel-item" data-bs-interval="3000">
            <img class="d-block w-100 image-slider" src="./assets/images/slider/img-slider4.png" alt="" height="600">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>

            <div class="carousel-item" data-bs-interval="3000">
            <img class="d-block w-100 image-slider" src="./assets/images/slider/img-slider5.png" alt="" height="600">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>
        </div>

        <!-- Botones laterales prev y next image -->
        <button class="carousel-control-prev" type="button" data-bs-target="#slider-index" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#slider-index" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- Sección ropa hombres -->
<div class="container p-4 hombres" id="hombres">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1 class="h4">HOMBRES</h1>
            <div>
                <button type="button" class="slider-prev">
                    <i class="bi bi-arrow-left-short"></i>
                </button>
                <button type="button" class="slider-next">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
    </div>
    <div class="slider-container position-relative">
        
        <div class="slider d-flex p-3">
            <!--Esto es lo nuevo que se integró-->
            <?php foreach ($productosHombres as $producto): ?>
                <div class="slider-item p-2">
                    <a href="./pages/productos.php?id=<?= $producto['id'] ?>&categoria_id=<?= $producto['categoria_id'] ?>">
                        <img class="img-fluid" src="./assets/images/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                        <h5 class="card-title mt-3"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= $producto['descripcion'] ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
            <!--Esto es lo antiguo de hombres que esta comentado-->
            <!--<div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camibuso.png" alt="Hombres 1">
                    <h5 class="card-title mt-3">Camibuso</h5>
                    <p class="card-text">Camibuso de Chevignon</p>
                </a>
            </div>
            
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camiseta.png" alt="Hombres 2">
                    <h5 class="card-title mt-3">Camiseta</h5>
                    <p class="card-text">Camiseta clásica</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisetaC.png" alt="Hombres 3">
                    <h5 class="card-title mt-3">Camiseta</h5>
                    <p class="card-text">Camiseta de Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-chaquetaC.png" alt="Hombres 4">
                    <h5 class="card-title mt-3">Chaqueta</h5>
                    <p class="card-text">Chaqueta de Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camibuso.png" alt="Hombres 5">
                    <h5 class="card-title mt-3">Camibuso</h5>
                    <p class="card-text">Camibuso de Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camibuso.png" alt="Hombres 6">
                    <h5 class="card-title mt-3">Camibuso</h5>
                    <p class="card-text">Camibuso de Chevignon</p>
                </a>
            </div>-->
        </div>
    </div>
</div>

<!-- Sección ropa mujeres -->
<div class="container p-4 mujeres" id="mujeres">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1 class="h4">MUJERES</h1>
            <div>
                <button type="button" class="slider-prev">
                    <i class="bi bi-arrow-left-short"></i>
                </button>
                <button type="button" class="slider-next">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
    </div>
    <div class="slider-container position-relative">
        <div class="slider d-flex p-3">
            <!--Esto es lo nuevo que se integró-->
            <?php foreach ($productosMujeres as $producto): ?>
                <div class="slider-item p-2">
                    <a href="./pages/productos.php?id=<?= $producto['id'] ?>&categoria_id=<?= $producto['categoria_id'] ?>">
                        <img class="img-fluid" src="./assets/images/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                        <h5 class="card-title mt-3"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= $producto['descripcion'] ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
            <!--Esto es lo antiguo de mujeres que esta comentado-->
            <!--<div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camibusoMujerC.png" alt="Mujeres 1">
                    <h5 class="card-title mt-3">Camibuso</h5>
                    <p class="card-text">Camibuso de mujer Chevignon</p>
                </a>
            </div>
            
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisetaMujer.png" alt="Mujeres 2">
                    <h5 class="card-title mt-3">Camiseta</h5>
                    <p class="card-text">Camiseta clásica</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisetaMujer2.png" alt="Mujeres 3">
                    <h5 class="card-title mt-3">Camiseta</h5>
                    <p class="card-text">Camiseta de Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisaMujerC2.png" alt="Mujeres 4">
                    <h5 class="card-title mt-3">Chaqueta</h5>
                    <p class="card-text">Chaqueta de Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisaMujerC.png" alt="Mujeres 5">
                    <h5 class="card-title mt-3">Camisa</h5>
                    <p class="card-text">Camisa de mujer Chevignon</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="img-fluid" src="./assets/images/img-camisetaMujer3.png" alt="Mujeres 6">
                    <h5 class="card-title mt-3">Camibuso</h5>
                    <p class="card-text">Camibuso de Chevignon</p>
                </a>
            </div>-->
        </div>
    </div>
</div>

<!-- Sección accesorios -->
<div class="container p-4 accesorios" id="accesorios">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h1 class="h4">ACCESORIOS</h1>
            <div>
                <button type="button" class="slider-prev">
                    <i class="bi bi-arrow-left-short"></i>
                </button>
                <button type="button" class="slider-next">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
    </div>
    <div class="slider-container position-relative">
        <div class="slider d-flex p-3">
            <!--Esto es lo nuevo que se integró-->
            <?php foreach ($productosAccesorios as $producto): ?>
                <div class="slider-item p-2">
                    <a href="./pages/productos.php?id=<?= $producto['id'] ?>&categoria_id=<?= $producto['categoria_id'] ?>">
                        <img class="prod-accesorio" src="./assets/images/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                        <h5 class="card-title mt-3"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= $producto['descripcion'] ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
            <!--Esto es lo antiguo de accesorios que esta comentado-->
            <!--<div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-billeteraCuero.png" alt="Accesorios 1">
                    <h5 class="card-title mt-3">Billetera</h5>
                    <p class="card-text">Billetera de Cuero Velez</p>
                </a>
            </div>
            
            <div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-cinturonCuero.png" alt="Accesorios 2">
                    <h5 class="card-title mt-3">Cinturon</h5>
                    <p class="card-text">Cinturon de Cuero Velez</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-billeteraCuero2.png" alt="Accesorios 3">
                    <h5 class="card-title mt-3">Billetera</h5>
                    <p class="card-text">Billetera de Cuero Velez</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-cinturonCuero2.png" alt="Accesorios 4">
                    <h5 class="card-title mt-3">Cinturon</h5>
                    <p class="card-text">Cinturon de Cuero Velez</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-cinturonCuero3.png" alt="Accesorios 5">
                    <h5 class="card-title mt-3">Cinturon</h5>
                    <p class="card-text">Cinturon de Cuero Velez</p>
                </a>
            </div>
    
            <div class="slider-item p-2">
                <a href="#">
                    <img class="prod-accesorio" src="./assets/images/img-billeteraCuero3.png" alt="Accesorios 6">
                    <h5 class="card-title mt-3">Cinturon</h5>
                    <p class="card-text">Cinturon de Cuero Velez</p>
                </a>
            </div>-->
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>