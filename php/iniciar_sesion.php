<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*== Almacenando datos ==*/
$usuario = limpiar_cadena($_POST['login_usuario']);
$clave = limpiar_cadena($_POST['login_clave']);

/*== Verificando campos obligatorios ==*/
if ($usuario == "" || $clave == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El USUARIO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La CLAVE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

$check_user = conexion();
$check_user = $check_user->query("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");
if ($check_user->rowCount() == 1) {

    $check_user = $check_user->fetch();
    if ($check_user['usuario_usuario'] == $usuario && $check_user['usuario_clave']==$clave) {

        $_SESSION['id'] = $check_user['usuario_id'];
        $_SESSION['nombre'] = $check_user['usuario_nombre'];
        $_SESSION['apellido'] = $check_user['usuario_apellido'];
        $_SESSION['rol'] = $check_user['usuario_rol'];
        $_SESSION['usuario'] = $check_user['usuario_usuario'];

        echo '
            <div class="notification is-info is-light">
                <strong>¡Inicio de sesión exitoso!</strong><br>
                Has iniciado sesión correctamente.
            </div>
        ';

        // Redirigir a la URL almacenada en la sesión, o por defecto a 'index.php?vista=home'
        $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index2.php?view=home';

        // Limpiar la URL de redireccionamiento después de usarla
        unset($_SESSION['redirect_url']);

        if (headers_sent()) {
            echo "<script> window.location.href='$redirect_url'; </script>";
        } else {
            header("Location: $redirect_url");
        }
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
    }
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Usuario o clave incorrectos
        </div>
    ';
}
$check_user = null;
?>
