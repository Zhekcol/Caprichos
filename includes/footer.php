<footer>
    <ul class="menu-footer-container">
            <a href="#" class="menu-item">Términos y condiciones</a>
            <li class="menu-item">Dirección</li>
            <li class="menu-item">Ayuda</li>
    </ul>
        <span class="copyright">&copy; Caprichos 2025</span>
</footer>
<?php if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['usuario_nombre'])) { ?>
<script src="./assets/js/multi-slider.js"></script>
<?php } ?>

<?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nombre'])) { ?>
<script src="<?= BASE_URL ?>assets/js/contenidoSecciones.js"></script>
<script src="<?= BASE_URL ?>assets/js/botonTalla.js"></script>
<?php } ?>
</body>
</html>