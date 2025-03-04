<?php
// pages/index.php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

include '../includes/header.php';
?>

<!-- Catálogo hombres -->
<div class="container contenido-hombres" id="hombres">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camiseta.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-chaquetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camibuso.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camibuso.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-chaquetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camiseta.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Catálogo mujeres -->
<div class="container contenido-mujeres" id="mujeres">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisetaMujer.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisetaMujer2.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisetaMujer3.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camibusoMujerC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisaMujerC2.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camisaMujerC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-chaquetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camiseta.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Catálogo accesorios -->
<div class="container contenido-accesorios" id="accesorios">
    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-2">
        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-billeteraCuero.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Billetera</h1>
                <p class="card-text">Billetera de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-billeteraCuero2.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Billetera</h1>
                <p class="card-text">Billetera de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-cinturonCuero.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Cinturon</h1>
                <p class="card-text">Cinturon de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-cinturonCuero2.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Cinturon</h1>
                <p class="card-text">Cinturon de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-cinturonCuero3.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Cinturon</h1>
                <p class="card-text">Cinturon de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-cinturonCuero4.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Cinturon</h1>
                <p class="card-text">Cinturon de cuero</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-chaquetaC.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-light">
                <a href="" class="text-decoration-none text-dark align-items-start">
                <img src="<?= BASE_URL ?>assets/images/img-camiseta.png" alt="" class="img-fluid">
                <div class="card-body text-start px-0">
                <h1 class="h5 card-title">Camiseta</h1>
                <p class="card-text">Camiseta de chevignon</p>
                <p class="card-text">120.000$</p>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>