document.addEventListener('DOMContentLoaded', function () {
    // Función para mostrar el contenedor correspondiente
    function mostrarContenido() {
        // Oculta todos los contenedores
        document.querySelectorAll('.contenido-hombres, .contenido-mujeres, .contenido-accesorios').forEach(function (contenedor) {
            contenedor.style.display = 'none';
        });

        // Muestra el contenedor correspondiente al hash de la URL
        const hash = window.location.hash;//hash es el numeral hombres o mujeres
        
        if (hash) {
            const contenedor = document.querySelector(`.contenido-${hash.substring(1)}`);
            if (contenedor) {
                contenedor.style.display = 'block';
            }
        }else{
            document.querySelectorAll('.contenido-hombres, .contenido-mujeres, .contenido-accesorios').forEach(function (contenedor) {
                contenedor.style.display = 'block';
            });
        }
    }

    // Ejecuta la función al cargar la página
    mostrarContenido();

    // Ejecuta la función cada vez que cambia el hash de la URL
    window.addEventListener('hashchange', mostrarContenido);
});