<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

$sql = "SELECT * FROM vista_informe_pedidos";
$result = executeQuery($mysqli, $sql)->get_result();

$filename = 'informe_pedidos_' . date('Ymd') . time() . '.csv';

// Forzar descarga de CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');

// Encabezados
$headers = array_keys($result->fetch_assoc());
fputcsv($output, $headers, ';'); // separador punto y coma para LibreOffice

// Volver al primer registro
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
    foreach ($row as &$valor) {
        if (is_numeric($valor) && strpos($valor, '.') !== false) {
            // Formatear número con coma decimal y punto de miles
            $valor = number_format((float) $valor, 2, ',', '.');
        }
    }
    fputcsv($output, $row, ';');
}

fclose($output);
exit();
