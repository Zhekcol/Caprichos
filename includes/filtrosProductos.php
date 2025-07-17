<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

function obtenerProductos($mysqli, $genero = '', $categoria = '') {
    if (!empty($genero)) {
        if (!empty($categoria)) {
            $sql = "
                SELECT p.* 
                FROM productos p 
                JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.genero = ? AND c.nombre = ?
            ";
            $stmt = executeQuery($mysqli, $sql, [$genero, $categoria], "ss");
        } else {
            $sql = "SELECT * FROM productos WHERE genero = ?";
            $stmt = executeQuery($mysqli, $sql, [$genero], "s");
        }
    } else {
        $sql = "SELECT * FROM productos";
        $stmt = executeQuery($mysqli, $sql);
    }

    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $productos;
}

function clasificarProductosPorGenero($productos) {
    return [
        'Hombre' => array_filter($productos, fn($p) => $p['genero'] === 'Hombre'),
        'Mujer' => array_filter($productos, fn($p) => $p['genero'] === 'Mujer'),
        'Accesorio' => array_filter($productos, fn($p) => $p['genero'] === 'Accesorio'),
    ];
}

function obtenerCategoriasPorGenero($mysqli, $genero) {
    $sql = "
        SELECT DISTINCT c.nombre
        FROM categorias c
        JOIN productos p ON c.id = p.categoria_id
        WHERE p.genero = ?
    ";
    $stmt = executeQuery($mysqli, $sql, [$genero], "s");
    $resultado = $stmt->get_result();

    $categorias = [];
    while ($fila = $resultado->fetch_assoc()) {
        $categorias[] = $fila;
    }
    $stmt->close();

    return $categorias;
}
