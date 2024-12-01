<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="./css/styles.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="container-form">
            <div class="container-left">
                <img src="./img/logo.webp" alt="Logo" class="login-image">
            </div>
            <div class="container-right">
                <h1 id="login-title">INICIO DE SESIÓN</h1>
                <form method="POST" action="./validacionesPHP/validacionLogin.php" id="cargaForm">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario">
                    <span id="error_usuario" class="error-message"></span>
                    <label for="pwd">Contraseña</label>
                    <input type="password" name="pwd" id="pwd">
                    <span id="pwd_error" class="error-message"></span>
                    <button type="submit" class="login-button" id="submitBtn">Acceder</button>
                </form>
            </div>
        </div>
    </div>
    <script src="./validacionesJS/validacionLogin.js"></script>
</body>

</html>