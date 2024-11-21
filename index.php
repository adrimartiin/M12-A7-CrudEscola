<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>INICIO DE SESIÓN</h1>
    <form method="POST" action="./validacionesPHP/validacionLogin.php">
        <label>Usuario</label>
        <input type="text" name="usuario" id="usuario">
        <span id="error_usuario" class="error-message"></span>
        <label>Contraseña</label>
        <input type="text" name="pwd" id="pwd">
        <span id="pwd_error" class="error-message"></span>

        <?php if (isset($_SESSION['error'])): ?>
            <span class="error-message" style="color: red;"><?php echo $_SESSION['error']; ?></span>
            <?php unset($_SESSION['error']);?>
            <?php endif; ?>
            
            <button type="submit" class="login-button" id="submitBtn">Acceder</button>
        </form>
    </div>
        <script src="../validacionesJS/validacionLogin.js"></script>
    
</body>
</html>
