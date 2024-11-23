
<head>
    <link rel="stylesheet" href="./css/style_navbar.css">
    <script src="./js/cerrar_sesion.js"></script>
</head>

<header>
    <nav class="navbarsgc">
        <div class="logo-container">
            <a href="index2.php?view=home"><img src="img/logo-naranja.jpg" alt="Logo Institucional"></a>
        </div>
         <span class="sgc-text">Encuestas A-2025</span> <!-- Texto añadido -->
        <label class="hamburger" id="hamburger">&#9776;</label>
        <ul class="nav-links menu" id="menu">
            <?php if ($_SESSION['rol'] == 'SISTEMAS' ):  ?>
            <li class="dropdown">
                <a href="#">Usuarios</a>
                <ul class="dropdown-menu">
                    <li><a href="index2.php?view=user_new">Nuevo</a></li>
                    <li><a href="index2.php?view=user_list">Lista</a></li>
                    <li><a href="index2.php?view=user_search">Buscar</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <li class="dropdown">
                <a href="index2.php?view=area_by_rol">Áreas</a>
            </li>
            <li><a href="#" class="boton1" id="logoutButton"><i class="fas fa-sign-out-alt"></i>Salir</a></li>
        </ul>
    </nav>
</header>
    <br>
    <br>

  
<!-- Modal -->
<div class="modal" id="logoutModal" ">
    <div class="modal-background" ></div>
    <div class="modal-card" style="border-radius:15px;">
        <header class="modal-card-head" style="background-color:#fee2bf;">
            <p class="modal-card-title">Confirmar salida</p>
            <button class="delete" aria-label="close" id="closeModal"></button>
        </header>
        <section class="modal-card-body">
            <p class="modal-text">¿Estás seguro de que quieres salir?</p>
        </section>
        <footer class="modal-card-foot" style="background-color:#fee2bf;">
            <button class="button is-danger" id="confirmLogout" style="background-color: #cc592b;">
                <i class="fas fa-sign-out-alt"></i> &nbsp; Salir
            </button>
            <button class="button" id="cancelLogout">
                <i class="fas fa-times"></i>&nbsp; Cancelar
            </button>
        </footer>
    </div>
</div>

