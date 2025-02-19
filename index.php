<?php include('includes/header.php'); ?>

<div class="container py-4">
    <div class="carousel slide" id="slider-index" data-bs-ride="carousel">
        <!-- Botones inferiores indicativos de cada imagen -->
        <div class="carousel-indicators">
            <button type="button" class="active" data-bs-target="#slider-index" data-bs-slide-to="0"></button>
            <button type="button" data-bs-target="#slider-index" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#slider-index" data-bs-slide-to="2"></button>
        </div>

        <!-- carousel con efecto desbanecido(fade) -->
        <div class="carousel-inner carousel-fade">

            <div class="carousel-item active" data-bs-interval="3000">
                <img class="d-block w-100 image-slider" src="./assets/images/img-slider1.png" alt="" height="600">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>

            <div class="carousel-item" data-bs-interval="3000">
            <img class="d-block w-100 image-slider" src="./assets/images/img-slider4.png" alt="" height="600">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>

            <div class="carousel-item" data-bs-interval="3000">
            <img class="d-block w-100 image-slider" src="./assets/images/img-slider5.png" alt="" height="600">
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

<?php include('includes/footer.php'); ?>