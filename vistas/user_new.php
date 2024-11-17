<style>
    .form{
        background-color:white;
        padding:40px;
        border-radius:15px;
        
    }
</style>
<body>
    <div class="container">
    <div class="container is-fluid mb-6">
        <br>
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Nuevo usuario</h2>
</div>
<div class="container pb-6 pt-6">
    <div class="form">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/usuario_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Nombres</label>
                    <input style="font-family: 'Poppins';"class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Apellidos</label>
                    <input style="font-family: 'Poppins';"class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Rol</label>
                    <br>
                    <div class="select style="width: 100%; font-family: 'Poppins'; max-width: 400px;">
                        <select style="font-family:'Poppins';" name="usuario_rol" required >
                            <option style="font-family:'Poppins';" value="ADMINISTRADOR">ADMINISTRADOR</option>
                            <option style="font-family:'Poppins';" value="GENERAL">GENERAL</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Usuario</label>
                    <input style="font-family: 'Poppins';"class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Email</label>
                    <input style="font-family: 'Poppins';"class="input" type="email" name="usuario_email" maxlength="70" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Clave</label>
                    <input style="font-family: 'Poppins';"class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label style="font-family: 'Poppins';">Repetir clave</label>
                    <input style="font-family: 'Poppins';"class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                </div>
            </div>
        </div>
        <div class="columns">
            
        </div>
        <p class="has-text-centered">
    <button type="submit" class="button is-info is-rounded" style="background-color: #613b9c; font-family: 'Poppins'; border-color: #613b9c; color: white;">
        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
    </button>
</p>-
    </form>
    </div>
</div>
       
    </div>


</body>
