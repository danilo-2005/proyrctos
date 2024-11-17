<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./php/main.php";

$id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
$id = limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <?php if($id == $_SESSION['id']) { ?>
        <h1 class="title">Mi cuenta</h1>
        <h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else { ?>
        <h1 class="title">Usuarios</h1>
        <h2 class="subtitle">Actualizar usuario</h2>
    <?php } ?>
</div>

<div class="container pb-6 pt-6">
    <?php
    include "./inc/btn_back.php";

    /*== Verificando usuario ==*/
    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE usuario_id='$id'");

    if ($check_usuario->rowCount() > 0) {
        $datos = $check_usuario->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>" required>
        
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['usuario_nombre']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['usuario_apellido']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Rol</label>
                    <br>
                    <div class="select custom-selectt">
                        <select name="usuario_rol" required>
                            <option value="ADMINISTRADOR" <?php echo ($datos['usuario_rol'] == 'ADMINISTRADOR') ? 'selected' : ''; ?>>ADMINISTRADOR</option>
                            <option value="SUPERVISOR" <?php echo ($datos['usuario_rol'] == 'SUPERVISOR') ? 'selected' : ''; ?>>SUPERVISOR</option>
                            <option value="SERVICIOS GENERALES" <?php echo ($datos['usuario_rol'] == 'SERVICIOS GENERALES') ? 'selected' : ''; ?>>SERVICIOS GENERALES</option>
                            <option value="SECRETARIAS" <?php echo ($datos['usuario_rol'] == 'SECRETARIAS') ? 'selected' : ''; ?>>SECRETARIAS</option>
                            <option value="PRACTICANTES" <?php echo ($datos['usuario_rol'] == 'PRACTICANTES') ? 'selected' : ''; ?>>PRACTICANTES</option>
                            <option value="INVITADO" <?php echo ($datos['usuario_rol'] == 'INVITADO') ? 'selected' : ''; ?>>INVITADO</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required value="<?php echo $datos['usuario_usuario']; ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['usuario_email']; ?>">
                </div>
            </div>
        </div>
        <br><br>
        <p class="has-text-centered">
            SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
        </p>
        <br>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Repetir clave</label>
                    <input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                </div>
            </div>
        </div>
        <br><br><br>
        <p class="has-text-centered">
            Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
        </p>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php 
    } else {
        include "./inc/error_alert.php";
    }
    $check_usuario = null;
    ?>
</div>
