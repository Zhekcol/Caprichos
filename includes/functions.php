<?php 
//validación de campos de formularios
function validarNombre($name){
    // Elimina espacios en blanco al inicio y al final
    $name = trim($name);
    $name = stripslashes($name);
    $name = htmlspecialchars($name);

    $error = "";
    // Verifica la longitud
    if (strlen($name) < 3 || strlen($name) > 99) {
        $error = "El campo Nombre debe contener mínimo 3 caracteres.";
    }

    // Verifica los caracteres permitidos
    if (!preg_match('/^[a-zA-Z0-9_\s-]+$/', $name)) {
        $error = "El campo Nombre solo permite letras, numeros  y guiones.";
    }

    if (empty($name)) {
        $error = "El campo Nombre es obligatorio.";
    }

    return $error;
}

function validarEmail($email) {
    $email = trim($email);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);

    $error = "";
    // Verifica el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de Correo electrónico inválido";
    }

    if (empty($email)) {
        $error = "El campo Correo electrónico es obligatorio.";
    }

    return $error;
}

function validarContraseña($password) {
    // Verifica la complejidad
    //mayúsculas, minúsculas, números y caracteres especiales.
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "El campo Contraseña debe tener al menos una mayúscula, una minúscula, un número y un caracter especial.";
        // Verifica la longitud
        if (strlen($password) < 8) {
            $error = "El campo Contraseña debe tener al menos 8 caracteres.";
        }
    }

    if (empty($password)) {
        $error = "El campo Contraseña es obligatorio.";
    }
    
    return $error;
}

//Verificar si el email ya existe para evitar un duplicado
function emailExiste($mysqli, $email) {
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $params = [$email];
    $types = "s";
    $stmt = executeQuery($mysqli, $sql, $params, $types);
    $stmt->store_result(); //para obtener el número de filas coincidentes.

    // $stmt->num_rows > 0;// Devuelve `true` si el email ya existe
    if ($stmt->num_rows > 0) {
        $error = "El Correo electrónico ingresado ya existe.";
        return $error;
    }
}

?>