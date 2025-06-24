const botonesTallas = document.querySelectorAll('.bTalla');

botonesTallas.forEach(boton => {
    boton.addEventListener('click', function () {
        // Remueve la clase 'active' de todos los botones
        botonesTallas.forEach(btn => btn.classList.remove('active'));
        
        // Agrega la clase 'active' al botón seleccionado
        this.classList.add('active');
        
    });
});