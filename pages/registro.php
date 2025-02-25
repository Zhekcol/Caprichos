<?php
session_start();
$csrf_token = bin2hex(random_bytes(32)); // Genera un token aleatorio
$_SESSION['csrf_token'] = $csrf_token; // Almacena el token en la sesión
$errores = $_SESSION['errores'] ?? []; // Tomar errores si existen
unset($_SESSION['errores']); // Limpiar errores después de tomarlos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../assets/css/formularios/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-3 col-sm-1"></div>

            <div class="col-lg-6 col-sm-10">
                <form action="../includes/validar_registro.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="name" class="form-control form-control-lg" name="name" id="name" >
                            <?php if (!empty($errores['name'])): ?>
                            <div class="alert alert-danger alert-dismissible mt-2">
                                    <span><?php echo $errores['name']; ?></span>
                                    <button class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="close"
                                    ></button>
                            </div>
                            <?php endif; ?>
                            
                    </div>

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
                    <div class="d-flex gap-2">
                        <button type="submit" class="registrarseButton">Registrarse</button>
                        <a href="../pages/login.php" class="btn btn-success">Cancelar</a>
                    </div>
                        
                </form>
            </div>

            <div class="col-lg-3 col-sm-1"></div>

        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>