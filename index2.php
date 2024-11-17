<?php 
require "./inc/session_start.php"; 

// Función para validar el nombre de archivo seguro
function is_valid_page($page) {
    return preg_match('/^[a-zA-Z0-9_-]+$/', $page);
}

// Determinar la vista o formulario a cargar
if (isset($_GET['view']) && is_valid_page($_GET['view'])) {
    $page = $_GET['view'];
    $file_path = "./vistas/" . $page . ".php";
} elseif (isset($_GET['forms']) && is_valid_page($_GET['forms'])) {
    $page = $_GET['forms'];
    $file_path = "./forms/" . $page . ".php";
} else {
    $page = "login";
    $file_path = "./vistas/login.php";
}

// Incluir la vista correspondiente
if (is_file($file_path) && $page != "login" && $page != "404") {

    // Validar sesión activa
    if (empty($_SESSION['id']) || empty($_SESSION['usuario'])) {
        header("Location: ./vistas/logout.php");
        exit();
    }

    include "./inc/head.php";
    include "./inc/navbar.php";
    
    include $file_path;
    include "./inc/script.php";

} else {
    include "./inc/head.php";
    include $page == "login" ? "./vistas/login.php" : "./vistas/404.php";
}
?>
