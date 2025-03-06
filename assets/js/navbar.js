document.addEventListener('DOMContentLoaded', function () {
    // Función para agregar o quitar la clase "active" según la URL actual
    function updateActiveLink() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link'); // Selecciona todos los enlaces
        const currentUrl = window.location.href; // Obtiene la URL actual

        navLinks.forEach(link => {
            // Remueve la clase "active" de todos los enlaces
            link.classList.remove('active');

            // Verifica si el href del enlace coincide con la URL actual
            if (link.href === currentUrl) {
                link.classList.add('active'); // Agrega la clase "active" al enlace correspondiente
            }
        });
    }

    // Ejecuta la función al cargar la página
    updateActiveLink();

    // Ejecuta la función cada vez que cambia la URL
    window.addEventListener('popstate', updateActiveLink);

    // Selecciona todos los enlaces de las secciones
    const sectionLinks = document.querySelectorAll('.nav-link[data-target]');

    // Función para manejar el clic en los enlaces de las secciones
    function handleSectionClick(event) {
        // Verifica si la pantalla es pequeña (dispositivo móvil)
        if (window.innerWidth <= 992) { // Ajusta el valor según el breakpoint de tu diseño
            event.preventDefault(); // Evita que la página se recargue

            // Obtiene el menú desplegable correspondiente
            const target = this.getAttribute('data-target');
            const dropdown = document.querySelector(target);

            // Alterna la visibilidad del menú desplegable
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        }
    }

    // Agrega el evento clic a los enlaces de las secciones
    sectionLinks.forEach(link => {
        link.addEventListener('click', handleSectionClick);
    });
});