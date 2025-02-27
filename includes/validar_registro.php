<?php 
session_start();
include '../includes/db.php';
include '../includes/functions.php';// Incluye funciones para validar campos de formulario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errores'] = []; // Inicializar errores
    $_SESSION['old_data'] = $_POST; // Guardar los datos ingresados

    // Verificar si la solicitud proviene de tu sitio web
    if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) === 'http://localhost/Caprichos/index.php') {
        // Continúa con el procesamiento del formulario
    } else {
        header('Location: ../pages/registro.php');
    }

    // Verificar el token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../pages/registro.php');
    }


    // Validar campo nombre
    $nombre = $_POST['name'];
    $resultName =  validarNombre($nombre);
    if (!empty($resultName)) {
        $_SESSION['errores']['name'] = $resultName;
    }
    
    //Validar campo email
    $email = $_POST['email'];
    $resultEmail =  validarEmail($email);
    if (!empty($resultEmail)) {
        $_SESSION['errores']['email'] = $resultEmail;
    }

    //Verificar duplicado de campo email
    $emaiExiste = emailExiste($mysqli, $email);
    if (!empty($emaiExiste)) {
        $_SESSION['errores']['email'] = $emaiExiste;
    }

    //Validar campo password
    $contraseña = $_POST['password'];
    $resultContraseña =  validarContraseña($contraseña);
    if (!empty($resultContraseña)) {
        $_SESSION['errores']['password'] = $resultContraseña;
    }
    
    $password = password_hash($contraseña, PASSWORD_BCRYPT); // Encripta la contraseña

    if (empty($_SESSION['errores'])) {
        // Inserta el usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $params = [$nombre, $email, $password];
        $types = "sss";
        $stmt = executeQuery($mysqli, $sql, $params, $types);

        // Redirigir al login si no hay errores
        header('Location: ../pages/login.php');
        exit();
    } else {
        // Si hay errores, redirigir al formulario de registro
        header('Location: ../pages/registro.php');
        exit();
    }
    
}

?>