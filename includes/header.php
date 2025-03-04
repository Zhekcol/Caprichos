<?php include_once __DIR__ . '/../config/config.php'; ?>
<?php 
    if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) {
        include '../includes/filtrosProductos.php'; 
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caprichos</title>
    <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/contenidoSecciones/estilos.css">
    <?php } ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/paginas-principales/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script defer src="<?= BASE_URL ?>assets/js/navbar.js"></script>
</head>
<body>
    <div class="container-fluid p-0">
            <div class="d-flex bg-light justify-content-end px-5" style="filter: brightness(95.5%);">
                <a class="btn" href="#" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; border: none;">Ayuda</a> |
                <a class="btn" href="#" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; border: none;">Contactanos</a> |
                <a class="btn" href="#" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; border: none;">Sobre nosotros</a>
            </div>
    </div>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logotipo -->
        <a class="navbar-brand" href="./index.php">
            <img class="img-fluid" src="<?= BASE_URL ?>assets/images/img-logo-letra.png" alt="" height="50" width="120">
        </a>
        <!-- Botón de toggler para dispositivos móviles -->
        <button type="button" class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#headerMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Contenedor del menú -->
        <div class="collapse navbar-collapse" id="headerMenu">
            <ul class="navbar-nav w-100 d-flex flex-column align-items-start d-lg-flex flex-lg-row justify-content-lg-center gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link text-dark inicio" href="./index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" id="man">Hombre</a>
                    <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
                    <ul class="dropdown-menu">
                        <li><h5 class="dropdown-header text-dark fw-bold">Ropa</h5></li>
                        <li><a href="#hombres" class="dropdown-item text-muted fw-bold">Toda la ropa</a></li>
                        <?php foreach ($categoriasPorGenero[$generos[0]] as $categoria) { ?>
                        <li><a href="" class="dropdown-item text-muted fw-bold"><?= $categoria['nombre']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#mujeres">Mujer</a>
                    <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
                    <ul class="dropdown-menu">
                    <li><h5 class="dropdown-header text-dark fw-bold">Ropa</h5></li>
                        <li><a href="#mujeres" class="dropdown-item text-muted fw-bold">Toda la ropa</a></li>
                        <?php foreach ($categoriasPorGenero[$generos[1]] as $categoria) { ?>
                        <li><a href="" class="dropdown-item text-muted fw-bold"><?= $categoria['nombre']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#accesorios">Accesorios</a>
                    <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
                    <ul class="dropdown-menu">
                    <li><h5 class="dropdown-header text-dark fw-bold">Ropa</h5></li>
                        <li><a href="#accesorios" class="dropdown-item text-muted fw-bold">Todos los accesorios</a></li>
                        <?php foreach ($categoriasPorGenero[$generos[2]] as $categoria) { ?>
                        <li><a href="" class="dropdown-item text-muted fw-bold"><?= $categoria['nombre']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>

                <?php if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['usuario_nombre'])) { ?>

                <!-- Botón "Iniciar sesión" como un elemento más del menú (visible solo en sm y md) -->
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-dark" href="./pages/login.php">Iniciar sesión</a>
                </li>
            </ul>
            <!-- Botón "Iniciar sesión" visible solo en pantallas grandes (lg) -->
            <div class="ms-auto d-none d-lg-block">
                <a class="btn btn-outline-dark btn-sm text-nowrap" href="./pages/login.php">Iniciar sesión</a>
            </div>

            <?php } else {  ?>

                <li class="nav-item d-lg-none">
                    <a class="nav-link text-dark" href="<?= BASE_URL ?>pages/logout.php">Cerrar sesión</a>
                </li>
            </ul>
            <div class="ms-auto d-none d-lg-block">
                <a class="btn btn-outline-dark btn-sm text-nowrap" href="<?= BASE_URL ?>pages/logout.php">Cerrar sesión</a>
            </div>

            <?php } ?>
        </div>
                
    </div>
</nav>

