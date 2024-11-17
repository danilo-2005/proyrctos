<?php
include('./php/main.php');
$pdo = conexion();
if (!isset($_SESSION['id'])) {
    echo 'No has iniciado sesión correctamente.';
    exit();
}
$id_usuario = $_SESSION['id'];
$query = "SELECT ETIQUETAS_ID, ETIQUETAS_NOMBRE FROM tb_etiquetas WHERE ETIQUETAS_USUARIO = :id_usuario";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$etiquetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <link rel="stylesheet" href="./css/style_navbar.css">
    <script src="./js/cerrar_sesion.js"></script>
    <script src="./js/navbar_activo.js"></script>
</head>

<body>

<div class="navbar">
    <ul>
    <li><a href="index2.php?view=home"><i class="fa-solid fa-house"></i><span style="font-family: 'Poppins';">&nbsp;Inicio</span></a></li>
    <li>
            <a href="#" id="usuariosToggle"><i class="fa-solid fa-users"></i><span style="font-family: 'Poppins';">&nbsp;Usuarios</span></a>
            <!-- Sublista de Libros -->
            <ul class="sublist" id="usuariosSublist">
                <li class="sublista"><a href="index2.php?view=user_new"> <span>&nbsp;Nuevos</span></a></li>
                <li><a href="#"><span>&nbsp;Listas</span></a></li>
            </ul>
        </li>
        <li>
            <a href="#" id="librosToggle"><i class="fa-solid fa-book-open"></i><span style="font-family: 'Poppins';">&nbsp;Libros</span></a>
            <!-- Sublista de Libros -->
            <ul class="sublist" id="librosSublist">
                <li class="sublista"><a href="#"> <span style="font-family: 'Poppins';">&nbsp;Nuevos</span></a></li>
                <li><a href="#"><span style="font-family: 'Poppins';">&nbsp;Listas</span></a></li>
            </ul>
        </li>
        <li><a href="index2.php?view=gest_directiva"><i class="fa-solid fa-list"></i><span style="font-family: 'Poppins';">&nbsp;Categorías</span></a></li>
        <li><a href=""><i class="fa-solid fa-star"></i><span style="font-family: 'Poppins';">&nbsp;Etiquetas</span></a></li>
        
        <!-- Mostrar las etiquetas -->
        <?php foreach ($etiquetas as $etiqueta): ?>
            <li class="etiquetas"><a href="etiquetas.php?id=<?php echo $etiqueta['ETIQUETAS_ID']; ?>"><span>&nbsp;<?php echo htmlspecialchars($etiqueta['ETIQUETAS_NOMBRE']); ?></span></a></li>
        <?php endforeach; ?>

        <li><a href="#" id="logoutButton"><i class="fas fa-sign-out-alt"></i><span style="font-family: 'Poppins';">&nbsp;Salir</span></a></li>
    </ul>
</div>


    <!-- Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-background"></div>
        <div class="modal-card" style="border-radius:15px;">
            <header class="modal-card-head" style="background-color:#f5f0ff;">
                <p class="modal-card-title">Confirmar salida</p>
                <button class="delete" aria-label="close" id="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <p class="modal-text">¿Estás seguro de que quieres salir?</p>
            </section>
            <footer class="modal-card-foot" style="background-color:#f5f0ff;">
                <button class="button is-danger" id="confirmLogout" style="background-color: #613b9c;">
                    <i class="fas fa-sign-out-alt"></i> &nbsp; Salir
                </button>
                <button class="button" id="cancelLogout">
                    <i class="fas fa-times"></i>&nbsp; Cancelar
                </button>
            </footer>
        </div>
    </div>