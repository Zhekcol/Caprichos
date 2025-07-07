<?php
include("db.php");
include '../includes/functions.php';// Incluye funciones para validar campos de formulario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST["codigo"]);
    $nueva_password = trim($_POST["nueva_password"]);
    $resultContraseña =  validarContraseña($nueva_password);
    if (!empty($resultContraseña)) {
        session_start();
        $_SESSION['errores']['password'] = $resultContraseña;
        $_SESSION['old_data'] = ['codigo' => $codigo];
        header("Location: ../pages/cambiar_contraseña.php");
        exit;
    }

    $nueva_password_hash = password_hash($nueva_password, PASSWORD_BCRYPT);

    // 1. Verificar si el código existe y no ha expirado
    $sql = "SELECT user_id FROM recuperacion_password WHERE codigo = ? AND expira > NOW()";
    $stmt = executeQuery($mysqli, $sql, [$codigo], "s");
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row["user_id"];

        // 2. Actualizar la contraseña
        $sql_update = "UPDATE usuarios SET password = ? WHERE id = ?";
        executeQuery($mysqli, $sql_update, [$nueva_password_hash, $user_id], "si");

        // 3. Eliminar el código usado (opcional pero recomendado)
        $sql_delete = "DELETE FROM recuperacion_password WHERE user_id = ?";
        executeQuery($mysqli, $sql_delete, [$user_id], "i");

        header("Location: ../pages/login.php?success=1");
        exit;
    } else {
        header("Location: ../pages/cambiar_contraseña.php?error=codigo_invalido");
        exit;
    }
}
?>
