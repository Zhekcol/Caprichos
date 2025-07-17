<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

//include('../includes/db.php');

function obtenerCategoriasPorGenero($mysqli, $genero) {
    // Consulta SQL para obtener categorías por género
    $sql = "
        SELECT DISTINCT c.nombre
        FROM categorias c
        JOIN productos p ON c.id = p.categoria_id
        WHERE p.genero = ?
    ";

    // Parámetros y tipos para la consulta preparada
    $params = [$genero];
    $types = "s"; // "s" porque $genero es un string

    // Ejecutar la consulta usando tu función executeQuery
    $stmt = executeQuery($mysqli, $sql, $params, $types);

    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();

    // Convertir el resultado en un array asociativo
    $categorias = [];
    while ($fila = $resultado->fetch_assoc()) {
        $categorias[] = $fila;
    }

    // Cerrar el statement
    $stmt->close();

    return $categorias;
}
// Array de géneros
$generos = ["Hombre", "Mujer", "Accesorio"];
// Array para almacenar las categorías por género
$categoriasPorGenero = [];
// Obtener categorías para cada género
foreach ($generos as $genero) {
    $categoriasPorGenero[$genero] = obtenerCategoriasPorGenero($mysqli, $genero);
}

?>