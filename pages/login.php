<?php 
session_start();
$errores = $_SESSION['errores'] ?? []; // Tomar errores si existen
unset($_SESSION['errores']); // Limpiar errores después de tomarlos
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inició de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/formularios/estilos.css">
</head>
<body>
    <div class="container p-4 mt-4">
        <div class="row">

            <div class="col-lg-3 col-sm-1"></div>

            <div class="col-lg-6 col-sm-10 mt-4">
                <form action="../includes/validar_login.php" method="post">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="email">
                        <?php if (!empty($errores['email'])): ?>
                            <div class="alert alert-danger alert-dismissible mt-2">
                                    <span><?php echo $errores['email']; ?></span>
                                    <button class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="close"
                                    ></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control form-control-lg" name="password" id="password">
                        <?php if (!empty($errores['password'])): ?>
                            <div class="alert alert-danger alert-dismissible mt-2">
                                    <span><?php echo $errores['password']; ?></span>
                                    <button class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="close"
                                    ></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                        <a href="../pages/registro.php" class="btn btn-success">Crear una cuenta</a>
                    </div>

                </form>

            </div>

            <div class="col-lg-3 col-sm-1"></div>

        </div>
        
        
    </div>


    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>