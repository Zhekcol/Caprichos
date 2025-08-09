<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Validar acceso solo a administradores
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

include_once __DIR__ . '/../includes/header.php';

// Consulta de usuarios
$sql = "SELECT id, nombre, email, rol
        FROM usuarios
        ORDER BY FIELD(rol, 'admin', 'cliente', 'user')";
$usuarios = executeQuery($mysqli, $sql)->get_result();
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Gestión de Roles de Usuarios</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr class="text-center align-middle">
                        <td><?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php if ($usuario['rol'] === 'admin'): ?>
                                <a href="#" class="btn btn-warning btn-accion"
                                    data-href="../includes/cambiar_rol.php?id=<?= $usuario['id'] ?>&rol=cliente"
                                    data-titulo="Quitar rol de administrador"
                                    data-mensaje="¿Seguro que deseas quitar el rol de administrador a <?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>?">
                                    Quitar Admin
                                </a>
                            <?php else: ?>
                                <a href="#" class="btn btn-success btn-accion"
                                    data-href="../includes/cambiar_rol.php?id=<?= $usuario['id'] ?>&rol=admin"
                                    data-titulo="Asignar rol de administrador"
                                    data-mensaje="¿Seguro que deseas asignar el rol de administrador a <?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>?">
                                    Hacer Admin
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="modalAccion" tabindex="-1" aria-labelledby="modalAccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalAccionLabel">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalAccionMensaje">
                <!-- Texto dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-primary" id="btnConfirmarAccion">Aceptar</a>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const botonesAccion = document.querySelectorAll('.btn-accion');
        const btnConfirmar = document.getElementById('btnConfirmarAccion');
        const modalTitulo = document.getElementById('modalAccionLabel');
        const modalMensaje = document.getElementById('modalAccionMensaje');
        const modalAccion = document.getElementById('modalAccion');

        if (modalAccion && btnConfirmar && botonesAccion.length > 0) {
            const modal = new bootstrap.Modal(modalAccion);

            botonesAccion.forEach(boton => {
                boton.addEventListener('click', function (e) {
                    e.preventDefault();
                    const href = this.getAttribute('data-href');
                    const titulo = this.getAttribute('data-titulo');
                    const mensaje = this.getAttribute('data-mensaje');

                    modalTitulo.textContent = titulo;
                    modalMensaje.textContent = mensaje;
                    btnConfirmar.setAttribute('href', href);

                    modal.show();
                });
            });
            // Asegurar que el botón Cancelar cierra bien
            modalAccion.addEventListener('hidden.bs.modal', function () {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
            });
        }
    });
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>