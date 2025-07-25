document.addEventListener('DOMContentLoaded', function() {
    const botonesCarrito = document.querySelectorAll('.agregar-carrito');
    const alertaCarrito = document.getElementById('alerta-carrito');
    let tallaSeleccionada = '';

    // Detectar talla seleccionada
    document.querySelectorAll('.bTalla').forEach(btn => {
        btn.addEventListener('click', function() {
            tallaSeleccionada = this.getAttribute('data-talla');
        });
    });

    botonesCarrito.forEach(boton => {
        boton.addEventListener('click', function() {
            
            // Verifica si el usuario tiene sesión usando la clase '.no-sesion'
            if (this.classList.contains('no-sesion')) {
                alert("Agrega al carrito iniciando sesión. O si lo prefieres... ¡reserva tu producto ahora mismo!");
                return; // Detiene la ejecución para no continuar con el fetch
            }

            const productoId = this.getAttribute('data-id');

            if (!tallaSeleccionada) {
                alert('Por favor selecciona una talla antes de agregar al carrito.');
                return;
            }

            fetch('../includes/agregar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `producto_id=${productoId}&talla=${tallaSeleccionada}`
            })
            .then(response => response.text())
            .then(data => {
                alertaCarrito.style.display = 'block';
                setTimeout(() => {
                    alertaCarrito.style.display = 'none';
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al agregar al carrito');
            });
        });
    });
});
