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
    }
});
