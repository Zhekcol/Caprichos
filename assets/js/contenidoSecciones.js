document.addEventListener('DOMContentLoaded', function () {
    // Función para mostrar el contenedor correspondiente
    function mostrarContenido() {
        // Oculta todos los contenedores
        const contenedores = document.querySelectorAll('.contenido-hombres, .contenido-mujeres, .contenido-accesorios');
        contenedores.forEach(function (contenedor) {
            contenedor.style.display = 'none';
        });

        // Obtiene el género desde la URL
        const urlParams = new URLSearchParams(window.location.search);
        const genero = urlParams.get('genero');

        // Muestra el contenedor correspondiente al género seleccionado
        if (genero) {
            //Si el genero es igual a Hombre o Accesorio se le agrega una s al parametro genero para que funcione el css de mostrar el contenido
            //Si es diferente, como "Mujer", se le agrega el 'es' para que quede como mujeres
            if (genero === 'Hombre' || genero === 'Accesorio') {
                var contenedor = document.querySelector(`.contenido-${genero.toLowerCase()}s`);
            }else {
                var contenedor = document.querySelector(`.contenido-${genero.toLowerCase()}es`);
            }
            
            if (contenedor) {
                contenedor.style.display = 'block';
            }
        } else {
            // Si no hay género seleccionado, muestra todos los contenedores
            contenedores.forEach(function (contenedor) {
                contenedor.style.display = 'block';
            });
        }
    }

    // Ejecuta la función al cargar la página
    mostrarContenido();

    // Ejecuta la función cada vez que cambia la URL
    window.addEventListener('popstate', mostrarContenido);
});

