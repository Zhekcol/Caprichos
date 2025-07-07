<?php
require __DIR__ . '/../vendor/autoload.php';

include("db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // 1. Verificar si el correo existe
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = executeQuery($mysqli, $sql, [$email], "s");
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $user_id = $usuario["id"];

        // 2. Generar código y fecha de expiración
        $codigo = rand(100000, 999999);
        $expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        // 3. Guardar el código en la base de datos
        $sql_insert = "INSERT INTO recuperacion_password (user_id, codigo, expira) VALUES (?, ?, ?)";
        executeQuery($mysqli, $sql_insert, [$user_id, $codigo, $expira], "iss");

        // 4. Enviar correo con PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // O el SMTP de tu proveedor
            $mail->SMTPAuth = true;
            $mail->Username = 'stivenrj09@gmail.com'; // Tu correo
            $mail->Password = 'bbeb bkmi qbbx uwqi'; // Clave de aplicación si usas Gmail
            $mail->SMTPSecure = 'tls'; // O 'ssl'
            $mail->Port = 587; // 465 si usas ssl

            $mail->setFrom('caprichos@gmail.com', 'Tienda Virtual');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Body = "
                <h3>Hola,</h3>
                <p>Tu código de recuperación es: <b>$codigo</b></p>
                <p>Este código expirará en 15 minutos.</p>
            ";
            
            $mail->send();
            header("Location: ../pages/cambiar_contraseña.php?success=1");
            exit;
        } catch (Exception $e) {
            header("Location: ../pages/recuperar_contraseña.php?error=envio_fallido");
            exit;
        }
    } else {
        header("Location: ../pages/recuperar_contraseña.php?error=correo_no_registrado");
        exit;
    }
}
?>
