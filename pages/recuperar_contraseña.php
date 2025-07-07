<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../assets/css/formularios/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

                <form action="../includes/enviar_codigo.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Ingresa tu correo electrónico:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="blackButton">Enviar código</button>
                        <a href="../pages/login.php" class="orangeButton"><i class="bi bi-caret-left-fill"></i>Regresar</a>
                    </div>
                    
                </form>
            </div>

            <div class="col-lg-3 col-sm-1"></div>

        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>