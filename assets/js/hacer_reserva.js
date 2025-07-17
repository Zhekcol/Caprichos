document.addEventListener('DOMContentLoaded', function() {
    const botonesReserva = document.querySelectorAll('.clic-reservar');
    let tallaSeleccionada = '';

    // Detectar talla seleccionada (compartido con el carrito)
    document.querySelectorAll('.bTalla').forEach(btn => {
        btn.addEventListener('click', function() {
            tallaSeleccionada = this.getAttribute('data-talla');
            // Actualizar data-talla en todos los botones de reserva
            botonesReserva.forEach(boton => {
                boton.setAttribute('data-talla', tallaSeleccionada);
            });
        });
    });

    // Manejar clic en botón de reserva
    botonesReserva.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const productoId = this.getAttribute('data-id');
            tallaSeleccionada = this.getAttribute('data-talla');

            if (!tallaSeleccionada) {
                alert('Por favor selecciona una talla antes de reservar.');
                return;
            }

            // Redirigir a la página de reserva con los parámetros
            window.location.href = `reserva.php?producto_id=${productoId}&talla=${encodeURIComponent(tallaSeleccionada)}`;
        });
    });
});
