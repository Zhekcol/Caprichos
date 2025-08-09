<footer>
    <ul class="menu-footer-container">
        <a href="#" class="menu-item">Términos y condiciones</a>
        <li class="menu-item">Dirección</li>
        <li class="menu-item">Ayuda</li>
    </ul>
    <span class="copyright">&copy; Caprichos 2025</span>
</footer>
<script>
    const userWasLoggedIn = <?= isset($_SESSION['usuario_id']) ? 'true' : 'false' ?>;

    setInterval(() => {
        fetch('<?= BASE_URL ?>includes/check-session.php')
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn !== userWasLoggedIn) {
                    // Se detectó un cambio. Ahora diferenciamos cuál.

                    // CASO 1: El usuario CERRÓ sesión en otra pestaña.
                    // (La página pensaba que sí había sesión, pero ahora ya no).
                    if (userWasLoggedIn === true && data.loggedIn === false) {
                        document.getElementById('session-alert').style.display = 'block';
                    }
                    // CASO 2: El usuario INICIÓ sesión en otra pestaña.
                    // (La página pensaba que no había sesión, pero ahora sí la hay).
                    else {
                        location.reload();
                    }
                }
            });
    }, 2000);
</script>
<div id="session-alert"
    style="display:none; position:fixed; top:0; left:0; width:100%; background-color: #ffc107; color: black; text-align:center; padding: 15px; z-index: 9999;">
    Tu sesión ha expirado. Por favor, <a href="#" onclick="location.reload(); return false;">haz clic aquí para
        refrescar la página</a>.
</div>

<?php
// Definir las páfinas que usarán el slider
$current_page = basename($_SERVER['PHP_SELF']);
$pages_with_slider = ['index.php'];

if (!isset($_SESSION['usuario_id']) && in_array($current_page, $pages_with_slider)) {
    echo '<script src="' . BASE_URL . 'assets/js/multi-slider.js"></script>';
}
?>
<script src="<?= BASE_URL ?>assets/js/botonTalla.js"></script>
<script src="<?= BASE_URL ?>assets/js/agregar_carrito.js"></script>
<script src="<?= BASE_URL ?>assets/js/hacer_reserva.js"></script>

<?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
    <script src="<?= BASE_URL ?>assets/js/contenidoSecciones.js"></script>
    <script src="<?= BASE_URL ?>assets/js/eliminar_pedido.js"></script>
    <script src="<?= BASE_URL ?>assets/js/pedido_accion.js"></script>
<?php } ?>
</body>

</html>