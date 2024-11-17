<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos generales del cuerpo */
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container-principal {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .container-principal img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        h5 {
            color: #6a11cb;
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .container1, .container2 {
            position: relative;
            margin-bottom: 20px;
        }

        label.label {
            font-weight: bold;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .container1 input, .container2 input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #ddd;
            border-radius: 30px;
            font-size: 14px;
            color: #555;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 40px;
            line-height: 1.5;
        }

        .container1 input:focus, .container2 input:focus {
            border-color: #6a11cb;
            box-shadow: 0 4px 8px rgba(106, 17, 203, 0.3);
            background-color: #f9f9ff;
        }

        .container1 i, .container2 i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: #888;
            font-size: 16px;
            pointer-events: none;
        }

        #togglePassword {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 16px;
        }

        .btn-inciar {
            background-color: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-inciar:hover {
            background-color: #4b0c94;
            box-shadow: 0 4px 10px rgba(75, 12, 148, 0.3);
        }

        .btn-inciar:focus {
            outline: none;
        }

        .btn-inciar i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container-principal">
    <form class="box login" action="" method="POST" autocomplete="off" onsubmit="convertToUppercase()">
        <div>
            <center><img src="./img/libro.png" alt="Log"></center>
        </div>
        <h5>Biblioteca</h5>

        <div class="container1">
            <label class="label">Usuario</label>
            <input type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>

        </div>

        <div class="container2">
            <label class="label">Clave</label>
            <input type="password" id="login_clave" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
        </div>

        <button type="submit" class="btn-inciar">
            <i class="fas fa-sign-in-alt"></i> Iniciar sesión
        </button>

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
