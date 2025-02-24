// Función para agregar o quitar la clase "active" según la URL actual
function updateActiveLink() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link'); // Selecciona todos los enlaces
    const currentUrl = window.location.href; // Obtiene la URL actual
    const inicio = document.querySelector('.inicio');
    
    navLinks.forEach(link => {

        // Remueve la clase "active" de todos los enlaces
        link.classList.remove('active');

        if (link.href === inicio.href && currentUrl === inicio.href) {
            link.classList.add('active'); // Agrega la clase "active" al enlace "Inicio"
        }

        // Verifica si el href del enlace coincide con la URL actual
        if (link.href === currentUrl && link.href === `${window.location.origin}${window.location.pathname}#${link.getAttribute('href').split('#')[1]}`) {
            link.classList.add('active'); // Agrega la clase "active" al enlace correspondiente
        }
    });
}

// Ejecuta la función al cargar la página
document.addEventListener('DOMContentLoaded', updateActiveLink);

// Ejecuta la función cada vez que cambia el hash de la URL
window.addEventListener('hashchange', updateActiveLink);