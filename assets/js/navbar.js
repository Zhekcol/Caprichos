//Obtener url actual
const currentUrl = window.location.href;

//Seleccionamos todos los enlaces del menú
const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

// Recorrer los enlaces y comparar con la URL actual
navLinks.forEach(link => {
    if (link.href === currentUrl) {
        link.classList.add('active'); // Agregar clase "active" al enlace correspondiente
    }
});
