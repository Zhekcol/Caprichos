<?php
// pages/carrito.php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../pages/login.php');
    exit();
}
?>