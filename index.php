<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "./inc/head.php"; ?>
    </head>
    <body>
        <?php

            // Priorizar 'view' sobre 'vista', y 'vista' sobre 'forms' si todos están presentes
            if(isset($_GET['view']) && $_GET['view']!="") {
                $page = $_GET['view'];
                $file_path = "./vistas/".$page.".php";
            } elseif(isset($_GET['forms']) && $_GET['forms']!="") {
                $page = $_GET['forms'];
                $file_path = "./forms/".$page.".php";
            } else {
                $page = "login";
                $file_path = "./vistas/login.php";
            }

            if(is_file($file_path) && $page!="login" && $page!="404"){

                /*== Cerrar sesion ==*/
                if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                    include "./vistas/logout.php";
                    exit();
                }

                include "./inc/navbar.php";

                include $file_path;

                include "./inc/script.php";

            } else {
                if($page == "login"){
                    include "./vistas/login.php";
                } else {
                    include "./vistas/404.php";
                }
            }
        ?>
        <?php include "./inc/footer.php"; ?>

    </body>
</html>