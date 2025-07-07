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
    <title>Actualizar Contraseña</title>
    <link rel="stylesheet" href="../assets/css/formularios/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="../assets/js/validarFormularios.js" defer></script>
</head>
<body>
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-3 col-sm-1"></div>

            <div class="col-lg-6 col-sm-10">
                <div>
                    <img src="../assets/images/img-logo-letra.png" alt="" class="img-fluid mx-auto d-block" height="200" width="200">
                </div>

                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success" role="alert">
                        Se ha enviado el código de recuperación a tu correo electrónico.
                    </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error']) && $_GET['error'] == 'codigo_invalido'): ?>
                    <div class="alert alert-danger" role="alert">
                        El código ingresado es incorrecto o ha expirado.
                    </div>
                <?php endif; ?>

                <form action="../includes/verificar_codigo.php" method="POST" id="formChangePassword">
                    <div class="form-group mb-3">
                        <label for="codigo" class="form-label">Código recibido por correo:</label>
                        <input type="text" name="codigo" class="form-control" required value="<?php echo $old_data['codigo'] ?? ''; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nueva_password" class="form-label">Nueva contraseña:</label>
                        <input type="password" name="nueva_password" class="form-control" id="nueva_password" required>
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

                    <button type="submit" class="blackButton">Cambiar contraseña</button>
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