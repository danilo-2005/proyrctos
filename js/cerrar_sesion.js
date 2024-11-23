document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const menu = document.querySelector('.menu');

    hamburger.addEventListener('click', () => {
        menu.classList.toggle('active');
    });

    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const closeModal = document.getElementById('closeModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');

    logoutButton.addEventListener('click', () => {
        logoutModal.classList.add('is-active');
    });

    closeModal.addEventListener('click', () => {
        logoutModal.classList.remove('is-active');
    });

    cancelLogout.addEventListener('click', () => {
        logoutModal.classList.remove('is-active');
    });

    confirmLogout.addEventListener('click', () => {
        window.location.href = 'index2.php?view=logout';
    });
});