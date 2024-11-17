document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');

    // Mostrar inicialmente expandida y luego colapsar después de 3 segundos
    setTimeout(() => {
        navbar.classList.add('collapsed');
    }, 3000); // 3000ms = 3 segundos
});
document.addEventListener('DOMContentLoaded', () => {
    const librosToggle = document.getElementById('librosToggle');
    const librosSublist = document.getElementById('librosSublist');

    // Asegurarnos de que la sublista esté oculta al cargar
    librosSublist.style.display = 'none';

    // Alternar visibilidad de la sublista al hacer clic
    librosToggle.addEventListener('click', (e) => {
        e.preventDefault(); // Evitar redirección del enlace
        if (librosSublist.style.display === 'none') {
            librosSublist.style.display = 'block';
        } else {
            librosSublist.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const usuariosToggle = document.getElementById('usuariosToggle');
    const usuariosSublist = document.getElementById('usuariosSublist');

    // Asegurarnos de que la sublista esté oculta al cargar
    usuariosSublist.style.display = 'none';

    // Alternar visibilidad de la sublista al hacer clic
    usuariosToggle.addEventListener('click', (e) => {
        e.preventDefault(); // Evitar redirección del enlace
        if (usuariosSublist.style.display === 'none') {
            usuariosSublist.style.display = 'block';
        } else {
            usuariosSublist.style.display = 'none';
        }
    });
});