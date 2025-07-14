<?php

//Definición de una URL base completa y dinámica para el proyecto
// Detecta el htps y el host del servidor
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Aquí se define la URL base para el proyecto
define('BASE_URL', $protocol . $host . '/Caprichos/');

/*
define('BASE_PATH', __DIR__ . '/');
define('BASE_URL', '/Caprichos/'); // Ajusta esto según tu estructura de proyecto
*/
?>