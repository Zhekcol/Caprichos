<?php 
session_start();
$errores = $_SESSION['errores'] ?? []; // Tomar errores si existen
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['errores'], $_SESSION['old_data']); // Limpiar errores después de tomarlos
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inició de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/formularios/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="../assets/js/validarFormularios.js" defer></script>
</head>
<body>
    <div class="container p-4 mt-4">
        <div class="row">

            <div class="col-lg-3 col-sm-1">
                <a href="../index.php" class="orangeButton">
                <i class="bi bi-caret-left-fill"></i>
                Volver </a>
            </div>

            <div class="col-lg-6 col-sm-10 mt-4">
                <div>
                    <img src="../assets/images/img-logo-letra.png" alt="" class="img-fluid mx-auto d-block" height="200" width="200">
                </div>
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success" role="alert">
                        Tu contraseña ha sido actualizada con éxito. Ahora puedes iniciar sesión.
                    </div>
                <?php endif; ?>
                <form action="../includes/validar_login.php" method="post" id="formLogin">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="email" value="<?= isset($old_data['email']) ? htmlspecialchars($old_data['email']) : '' ?>">
                        <?php if (!empty($errores['email'])): ?>
                            <div class="alert alert-warning alert-dismissible mt-2">
                                    <span><?php echo $errores['email']; ?></span>
                                    <button class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="close"
                                    ></button>
                            </div>
                        <?php endif; ?>
                        <div id="errorEmail"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control form-control-lg" name="password" id="password">
                        <a href="recuperar_contraseña.php" class="link-secondary link-offset-2 link-offset-3-hover link-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark">¿Has olvidado la contraseña?</a>
                        <?php if (!empty($errores['password'])): ?>
                            <div class="alert alert-warning alert-dismissible mt-2">
                                    <span><?php echo $errores['password']; ?></span>
                                    <button class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="close"
                                    ></button>
                            </div>
                        <?php endif; ?>
                        <div id="errorPassword"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="blackButton">Ingresar</button>
                        <a href="../pages/registro.php" class="blackButton">Crear una cuenta</a>
                    </div>

                </form>

            </div>

            <div class="col-lg-3 col-sm-1"></div>

        </div>
        
        
    </div>


    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        setTimeout(() => {
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(alert => alert.remove());
        }, 7000); // 7 segundos solo para alertas de éxito
    </script>
</body>
</html>