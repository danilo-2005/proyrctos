document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const closeModal = document.getElementById('closeModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');

    // Abrir el modal
    logoutButton.addEventListener('click', () => {
        logoutModal.classList.add('is-active');
    });

    // Cerrar el modal al hacer clic en el botón de cerrar
    closeModal.addEventListener('click', () => {
        logoutModal.classList.remove('is-active');
    });

    // Cancelar logout
    cancelLogout.addEventListener('click', () => {
        logoutModal.classList.remove('is-active');
    });

    // Confirmar logout
    confirmLogout.addEventListener('click', () => {
        window.location.href = 'index2.php?view=logout';
    });

    // Cerrar el modal si se hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target === logoutModal) {
            logoutModal.classList.remove('is-active');
        }
    });
});