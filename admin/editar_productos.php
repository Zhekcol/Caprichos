<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

/*if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de producto no proporcionado.</div>";
    exit();
}

$productoId = (int)$_GET['id'];*/

$esNuevo = !isset($_GET['id']);
$productoId = $esNuevo ? null : (int)$_GET['id'];


// Obtener datos del producto
/*$sql = "SELECT * FROM productos WHERE id = ?";
$producto = executeQuery($mysqli, $sql, [$productoId], 'i')->get_result()->fetch_assoc();

if (!$producto) {
    echo "<div class='alert alert-danger'>Producto no encontrado.</div>";
    exit();
}*/
if (!$esNuevo) {
    $sql = "SELECT * FROM productos WHERE id = ?";
    $producto = executeQuery($mysqli, $sql, [$productoId], 'i')->get_result()->fetch_assoc();

    if (!$producto) {
        echo "<div class='alert alert-danger'>Producto no encontrado.</div>";
        exit();
    }
} else {
    // Producto nuevo: valores por defecto
    $producto = [
        'nombre' => '',
        'descripcion' => '',
        'precio' => '',
        'imagen' => '',
        'genero' => 'Hombre',
        'categoria_id' => null,
    ];
}


// Obtener categorías
$categorias = executeQuery($mysqli, "SELECT * FROM categorias")->get_result();

// Obtener tallas y stock
$tallas = executeQuery($mysqli, "
    SELECT t.id, t.nombre, pt.stock
    FROM tallas t
    LEFT JOIN producto_talla pt ON pt.talla_id = t.id AND pt.producto_id = ?
", [$productoId], 'i')->get_result();

// Manejar POST (actualizar producto)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $genero = $_POST['genero'];
    // $categoria_id = intval($_POST['categoria_id']);
    // Verifica si se envió una nueva categoría
    if (!empty($_POST['nueva_categoria'])) {
      $nueva_categoria = trim($_POST['nueva_categoria']);
      // Verifica si ya existe (opcional)
      $check = executeQuery($mysqli, "SELECT id FROM categorias WHERE nombre = ?", [$nueva_categoria], 's')->get_result();
      if ($check->num_rows > 0) {
          $row = $check->fetch_assoc();
          $categoria_id = $row['id']; // Ya existe
      } else {
          // Insertar nueva categoría
          executeQuery($mysqli, "INSERT INTO categorias (nombre) VALUES (?)", [$nueva_categoria], 's');
          $categoria_id = $mysqli->insert_id; // Usar el nuevo ID
      }
    } else {
      $categoria_id = intval($_POST['categoria_id']); // Usar la seleccionada
    }

    // Manejo de imagen (si se sube una nueva)
    $imagen = $producto['imagen'];
    if (!empty($_FILES['imagen']['name'])) {
        $nombreImagen = basename($_FILES['imagen']['name']);
        $ruta = "../assets/images/" . $nombreImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
        $imagen = $nombreImagen;
    }

    if ($esNuevo) {
        // INSERTAR nuevo producto
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, genero, categoria_id) VALUES (?, ?, ?, ?, ?, ?)";
        executeQuery($mysqli, $sql, [$nombre, $descripcion, $precio, $imagen, $genero, $categoria_id], 'ssdssi');
        $productoId = $mysqli->insert_id;

        // Insertar tallas
        foreach ($_POST['tallas'] as $talla_id => $stock) {
            $stock = ($stock === '' || intval($stock) === 0) ? null : intval($stock);
            executeQuery($mysqli, "INSERT INTO producto_talla (producto_id, talla_id, stock, stock_reservado) VALUES (?, ?, ?, 0)", [$productoId, $talla_id, $stock], 'iii');
        }
    } else {
        // Actualizar producto
        $updateSQL = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, genero = ?, categoria_id = ? WHERE id = ?";
        executeQuery($mysqli, $updateSQL, [$nombre, $descripcion, $precio, $imagen, $genero, $categoria_id, $productoId], 'ssdssii');

        // Actualizar tallas
        foreach ($_POST['tallas'] as $talla_id => $stock) {
            $stock = ($stock === '' || intval($stock) === 0) ? null : intval($stock);

            // Verificar existencia y actualizar o insertar
            $check = executeQuery($mysqli, "SELECT 1 FROM producto_talla WHERE producto_id = ? AND talla_id = ?", [$productoId, $talla_id], 'ii')->get_result();
            if ($check->num_rows > 0) {
              executeQuery($mysqli, 
                  "UPDATE producto_talla SET stock = ? WHERE producto_id = ? AND talla_id = ?", 
                  [$stock, $productoId, $talla_id], 
                  'iii'
              );
            } else {
              executeQuery($mysqli, 
                  "INSERT INTO producto_talla (producto_id, talla_id, stock, stock_reservado) VALUES (?, ?, ?, 0)", 
                  [$productoId, $talla_id, $stock], 
                  'iii'
              );
            }
        }
        // Eliminar tallas con stock y reservado vacíos
        executeQuery($mysqli, "
            DELETE FROM producto_talla
            WHERE producto_id = ?
              AND (stock IS NULL OR stock = 0)
              AND (stock_reservado IS NULL OR stock_reservado = 0)
        ", [$productoId], 'i');
    }

    header("Location: inventario.php?mensaje=actualizado");
    exit();
}

include_once __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <!--<h2 class="text-center mt-4">Editar Producto</h2>-->
    <h2 class="text-center mt-4"><?= $esNuevo ? 'Agregar Nuevo Producto' : 'Editar Producto' ?></h2>
    <form method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Género:</label>
            <select name="genero" class="form-control" required>
                <option value="Hombre" <?= $producto['genero'] === 'Hombre' ? 'selected' : '' ?>>Hombre</option>
                <option value="Mujer" <?= $producto['genero'] === 'Mujer' ? 'selected' : '' ?>>Mujer</option>
                <option value="Accesorio" <?= $producto['genero'] === 'Accesorio' ? 'selected' : '' ?>>Accesorio</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Categoría:</label>
            <select name="categoria_id" class="form-control" required>
                <?php while ($cat = $categorias->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                        <?= $cat['nombre'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <small class="text-muted">O crea una nueva categoría abajo:</small>
            <input type="text" name="nueva_categoria" class="form-control mt-2" placeholder="Nueva categoría (opcional)">
        </div>
        <div class="mb-3">
            <label>Imagen actual:</label><br>
            <img src="../assets/images/<?= $producto['imagen'] ?>" width="120"><br>
            <label>Nueva imagen:</label>
            <input type="file" name="imagen" class="form-control">
        </div>
        <h5>Stock por Talla:</h5>
        <?php while ($talla = $tallas->fetch_assoc()): ?>
            <div class="mb-2">
                <label><?= $talla['nombre'] ?>:</label>
                <input type="number" name="tallas[<?= $talla['id'] ?>]" value="<?= $talla['stock'] ?? 0 ?>" class="form-control" required>
            </div>
        <?php endwhile; ?>
        <!--<button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>-->
        <button type="submit" class="btn btn-primary mt-3">
            <?= $esNuevo ? 'Agregar Producto' : 'Guardar Cambios' ?>
        </button>
        <a href="inventario.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
