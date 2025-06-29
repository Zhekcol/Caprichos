document.addEventListener('DOMContentLoaded', function () {
    // Script unificado

    // Cierre automático de la alerta
    const alerta = document.querySelector('.alert');
    if (alerta) {
        setTimeout(() => {
            alerta.classList.remove('show');
            alerta.classList.add('fade');
            setTimeout(() => alerta.remove(), 500);
        }, 3000);
    }

    // Modal de confirmación de eliminación
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    const btnConfirmar = document.getElementById('btnConfirmarEliminar');
    const modalEliminar = document.getElementById('modalEliminar');

    if (modalEliminar && btnConfirmar && botonesEliminar.length > 0) {
        const modal = new bootstrap.Modal(modalEliminar);
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.getAttribute('data-href');
                btnConfirmar.setAttribute('href', href);
                modal.show();
            });
        });
    }
});
