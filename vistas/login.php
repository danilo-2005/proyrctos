<head>
    <link rel="stylesheet" href="./css/style_login.css">
</head>
<body>
<div class="main-container">
    <form class="box login" action="" method="POST" autocomplete="off" onsubmit="convertToUppercase()">
        <div>
            <center><img src="img/logo-naranja.jpg" alt=""></center>
        </div>
        <br>
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de Gestión de Calidad</h5>

        <div class="field input-container">
            <label class="label">Usuario</label>
            <div class="control">
                <div class="input-container">
                    <input class="input input-uppercase" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="field input-container">
            <label class="label">Clave</label>
            <div class="control">
                <div class="input-container">
                    <input class="input input-password" type="password" id="login_clave" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                    <i class="fas fa-key"></i>
                    <i id="togglePassword" class="fas fa-eye"></i>
                </div>
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="login-button">
                <i class="fas fa-sign-in-alt"></i> Iniciar sesión
            </button>
        </p>

        <?php
            if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
            }
        ?>
    </form>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('login_clave');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    function convertToUppercase() {
        const userInput = document.querySelector('input[name="login_usuario"]');
        userInput.value = userInput.value.toUpperCase();
    }
</script>
</body>
</html>
S