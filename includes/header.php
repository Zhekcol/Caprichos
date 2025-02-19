<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caprichos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script defer src="./assets/js/navbar.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logotipo -->
        <a class="navbar-brand" href="./index.php">
            <img class="" src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/lion-fire-logo-design-template-free-89daa14626ac403bd3cf6282036663ff_screen.jpg?ts=1572094154" alt="" height="30">
        </a>
        <!-- Botón de toggler para dispositivos móviles -->
        <button type="button" class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#headerMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Contenedor del menú -->
        <div class="collapse navbar-collapse" id="headerMenu">
            <ul class="navbar-nav w-100 d-flex flex-column align-items-start d-lg-flex flex-lg-row justify-content-lg-center gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="./index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Contactanos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Acceder</a>
                </li>
                <!-- Botón "Iniciar sesión" como un elemento más del menú (visible solo en sm y md) -->
                <li class="nav-item d-lg-none">
                    <a class="nav-link text-dark" href="#">Iniciar sesión</a>
                </li>
            </ul>
            <!-- Botón "Iniciar sesión" visible solo en pantallas grandes (lg) -->
            <div class="ms-auto d-none d-lg-block">
                <a class="btn btn-outline-dark btn-sm text-nowrap" href="#">Iniciar sesión</a>
            </div>
        </div>
        
    </div>
</nav>

