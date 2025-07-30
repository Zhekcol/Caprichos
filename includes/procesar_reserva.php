<?php
// includes/procesar_reserva.php
session_start();

// Validar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    exit('Acceso no autorizado.');
}

// Inclusión segura de archivos
require_once __DIR__ . '/../includes/db.php';

// 1. Elaboro algunas funciones para resumir
function obtenerIdTalla($talla) {
    global $mysqli;
    // Validar talla
    if (empty($talla)) {
        die("No se recibió la talla.");
    }
    // 1. Buscar el ID de la talla por su nombre
    $sql = "SELECT id FROM tallas WHERE nombre = ? LIMIT 1";
    $stmt = executeQuery($mysqli, $sql, [$talla], "s");
    $result = $stmt->get_result();
    $talla = $result->fetch_assoc();
    $stmt->close();
    if (!$talla) {
        die("La talla no existe.");
    }
    $tallaId = $talla['id'];
    // echo "Talla ID: $tallaId<br>"; 
    // 2. Retornar el ID de la talla
    return $tallaId;
}

function validarTelefonoDireccionUsuario($usuario_id, $telefono, $direccion){
    global $mysqli;
    $telefonoBase = '';
    $direccionBase = '';
    // Validar que el usuario tenga teléfono y dirección
    $sql = "SELECT telefono, direccion FROM usuarios WHERE id = ?";
    $stmt = executeQuery($mysqli, $sql, [$usuario_id], "i");
    $stmt->bind_result($telefonoBase, $direccionBase);
    $stmt->fetch();
    $stmt->close();
    // Verificar si hay cambios
    $telefonoCambiado = $telefono !== $telefonoBase;
    $direccionCambiada = $direccion !== $direccionBase;
    if ($telefonoCambiado || $direccionCambiada) {
        // Actualizar solo si hay cambios
        $sql = "UPDATE usuarios SET telefono = ?, direccion = ? WHERE id = ?";
        executeQuery($mysqli, $sql, [$telefono, $direccion, $usuario_id], "ssi");
        echo "Teléfono y/o dirección actualizados.<br>";
    } else {
        echo "No hubo cambios en teléfono ni dirección.<br>";
    }
}

function crearUsuarioSiNoExiste($nombre, $email, $telefono, $direccion) {
    global $mysqli;
    // Verificar si el email ya existe
    $sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = executeQuery($mysqli, $sql, [$email], "s");
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        // El usuario ya existe: redireccionar
        echo "<script>
                alert('El correo ya está registrado. Debe iniciar sesión para continuar.');
                window.location.href = '../pages/login.php?redirect=reserva';
            </script>";
        exit();
    }
    $stmt->close();
    // Crear usuario
    $sql = "INSERT INTO usuarios (nombre, email, telefono, direccion, rol) VALUES (?, ?, ?, ?, 'user')";
    executeQuery($mysqli, $sql, [$nombre, $email, $telefono, $direccion], "ssss");
    // Obtener el ID del nuevo usuario
    $nuevo_id = $mysqli->insert_id;
    // echo "Usuario creado con ID: $nuevo_id<br>";
    return $nuevo_id;
}


// 2. Se establecen las variables (datos) a usar
$pedido_id = $_POST['pedido_id'] ?? null;
$producto_id = $_POST['producto_id'] ?? null;
// echo "Producto ID: $producto_id<br>";
$talla = $_POST['talla'] ?? null;
// echo "Talla: $talla<br>";

// Verificar si el usuario está autenticado
if (isset($_SESSION['usuario_id'])) {
    // Usuario autenticado
    $usuario_id = $_SESSION['usuario_id'];
    echo "Usuario ID: $usuario_id<br>";

    // Datos adicionales
    $telefono = $_POST['telefono'] ?? '';
    echo "Teléfono: $telefono<br>";
    $direccion = $_POST['direccion'] ?? '';
    echo "Dirección: $direccion<br>";
    // Validar teléfono y dirección del usuario
    validarTelefonoDireccionUsuario($usuario_id, $telefono, $direccion);
} else {
    // Usuario no autenticado
    // $usuario_id = null;
    // echo "Usuario no autenticado.\n";

    // Se requiere que los datos vengan del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    echo "Nombre: $nombre<br>";
    $email = trim($_POST['email'] ?? '');
    echo "Email: $email<br>";
    $telefono = trim($_POST['telefono'] ?? '');
    echo "Teléfono: $telefono<br>";
    $direccion = trim($_POST['direccion'] ?? '');
    echo "Dirección: $direccion<br>";
    
    // Validar que no estén vacíos
    if (!$nombre || !$email || !$telefono || !$direccion) {
        exit('Debe completar todos los campos del formulario.');
    }
    // Crear usuario si no existe
    $usuario_id = crearUsuarioSiNoExiste($nombre, $email, $telefono, $direccion);
}

// 3. Aqui comenzamos con la lógica de procesamiento de la reserva
try {
    if ($pedido_id) {
        // Caso 1: Viene desde carrito.php y el pedido existente
        // Verificar que el pedido existe y pertenece al usuario
        $sql = "SELECT id FROM pedidos WHERE id = ? AND usuario_id = ? AND estado = 'pendiente'";
        $result = executeQuery($mysqli, $sql, [$pedido_id, $usuario_id], "ii")->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("No se encontró el pedido pendiente.");
        }

        // Actualizar estado
        $sql = "UPDATE pedidos SET estado = 'reservado' WHERE id = ?";
        executeQuery($mysqli, $sql, [$pedido_id], "i");

        $pedidoFinal = $pedido_id;
    } else {
        // Caso 2: Viene desde productos.php para crear nuevo pedido y detalle
        if (!$producto_id || !$talla) {
            exit('Faltan datos obligatorios.');
        }

        $talla_id = obtenerIdTalla($talla);

        // Crear nuevo pedido
        $sql = "INSERT INTO pedidos (usuario_id) VALUES (?)";
        executeQuery($mysqli, $sql, [$usuario_id], "i");
        $pedido_id = $mysqli->insert_id;

        // Obtener precio
        $sql = "SELECT precio FROM productos WHERE id = ?";
        $producto = executeQuery($mysqli, $sql, [$producto_id], "i")->get_result()->fetch_assoc();
        if (!$producto) {
            throw new Exception("Producto no encontrado.");
        }

        // Insertar detalle
        $sql = "INSERT INTO detalles_pedido (pedido_id, producto_id, talla_id, precio, cantidad)
                VALUES (?, ?, ?, ?, 1)";
        executeQuery($mysqli, $sql, [$pedido_id, $producto_id, $talla_id, $producto['precio']], "iiid");

        // Calcular total y actualizar
        $sql = "SELECT SUM(precio * cantidad) AS total FROM detalles_pedido WHERE pedido_id = ?";
        $stmt = executeQuery($mysqli, $sql, [$pedido_id], "i");
        $total = $stmt->get_result()->fetch_assoc()['total'];
        $stmt->close();

        $sql = "UPDATE pedidos SET total = ?, estado = 'reservado' WHERE id = ?";
        executeQuery($mysqli, $sql, [$total, $pedido_id], "di");

        $pedidoFinal = $pedido_id;
    }

    // Mostrar resumen y redirigir
    $redirect = isset($_SESSION['usuario_id']) ? '../pages/index.php' : '../index.php';
    echo "<script>
            alert('Reserva exitosa.\\nID del Pedido: $pedidoFinal\\nEstado: Reservado\\n¡Espere ser contactado por el personal de ventas!');
            window.location.href = '$redirect';
        </script>";
    exit();

} catch (Exception $e) {
    $fallback = isset($_SESSION['usuario_id']) ? '../pages/reserva.php' : '../pages/login.php';
    echo "<script>
            alert('Error al procesar la reserva.\\n{$e->getMessage()}\\nIntente nuevamente.');
            window.location.href = '$fallback';
        </script>";
    exit();
}

