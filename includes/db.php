<?php 

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Obtener variables de entorno
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Configurar el charset a utf8 (para evitar problemas con caracteres especiales)
$mysqli->set_charset("utf8");

// Función para ejecutar consultas preparadas de forma segura
function executeQuery($mysqli, $sql, $params = [], $types = "") {
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    return $stmt;
}
?>