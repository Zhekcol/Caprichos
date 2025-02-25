<?php
// validar_login.php
session_start();
include '../includes/db.php';// Incluye la conexión a la base de datos
include '../includes/functions.php';// Incluye funciones para validar campos de formulario

//Validación para que no puedan cargar este archivo
if (isset($_SESSION['usuario_nombre'])) {
    header('Location: ../pages/index.php');
}else if (!isset($_POST['email'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Validar campo email
    $email = $_POST['email'];
    $resultEmail =  validarEmail($email);
    if (!empty($resultEmail)) {
        $_SESSION['errores']['email'] = $resultEmail;
    }

    $contraseña = $_POST['password'];
    $resultContraseña =  validarContraseña($contraseña);
    if (!empty($resultContraseña)) {
        $_SESSION['errores']['password'] = $resultContraseña;
    }
    $password = $contraseña;

    // Consulta SQL para buscar al usuario por email
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $params = [$email];
    $types = "s"; // "s" indica que el parámetro es un string

    // Se ejecuta la consulta usando la función executeQuery
    $stmt = executeQuery($mysqli, $sql, $params, $types);

    // Obtiene el resultado
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        if (password_verify($password, $usuario['password'])) {
            // Credenciales válidas
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
    
            // Redirige según el rol
            if ($usuario['rol'] === 'admin') {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../pages/index.php');
            }
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['errores']['password'] = "La contraseña es incorrecta o no está registrado.";
            header('Location: ../pages/login.php');
            exit();
        }
    } else {
        // El correo no existe en la base de datos
        $_SESSION['errores']['email'] = "El correo electrónico ingresado no está registrado.";
        header('Location: ../pages/login.php');
        exit();
    }
    
}
?>