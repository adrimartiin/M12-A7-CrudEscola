<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a la base de datos
    include_once '../db/conexion.php';

    // Recibir datos del formulario
    $nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $nombre_completo = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $password_usuario = password_hash($_POST['password_usuario'], PASSWORD_BCRYPT);
    $email_usuario = mysqli_real_escape_string($conn, $_POST['email_usuario']);
    $telf_usuario = mysqli_real_escape_string($conn, $_POST['telf_usuario']);
    $dni_usuario = mysqli_real_escape_string($conn, $_POST['dni_usuario']);
    $rol_usuario = mysqli_real_escape_string($conn, $_POST['rol_usuario']);

    // Comprobar si el nombre de usuario o el DNI ya existen
    $consulta = "SELECT * FROM tbl_usuario WHERE nombre_usuario = '$nombre_usuario' OR dni_usuario = '$dni_usuario'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<div class='alert alert-danger'>Error: El nombre de usuario o el DNI ya están registrados.</div>";
    } else {
        // Insertar en la base de datos
        $sql = "INSERT INTO tbl_usuario (nombre_usuario, nombre_completo, password_usuario, email_usuario, telf_usuario, dni_usuario, rol_usuario) 
                VALUES ('$nombre_usuario', '$nombre_completo', '$password_usuario', '$email_usuario', '$telf_usuario', '$dni_usuario', '$rol_usuario');";

        if (mysqli_query($conn, $sql)) {
            header("Location: leerEscuela.php");
        } else {
            echo "<div class='alert alert-danger'>Error al añadir usuario: " . mysqli_error($conn) . "</div>";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/editarRegistro.css">
    <title>Insertar Usuario</title>
</head>
<body>
<div class="container">
    <form action="" method="POST" id="insertForm">
    <h2>Insertar Usuario</h2>

        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario">
            <span class="error-message" id="error_username"></span>
        </div>

        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo">
            <span class="error-message" id="error_name"></span>
        </div>

        <div class="mb-3">
            <label for="password_usuario" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password_usuario" name="password_usuario">
            <span class="error-message" id="error_pwd"></span>
        </div>

        <div class="mb-3">
            <label for="email_usuario" class="form-label">Email</label>
            <input type="email" class="form-control" id="email_usuario" name="email_usuario">
            <span class="error-message" id="error_email"></span>
        </div>

        <div class="mb-3">
            <label for="telf_usuario" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telf_usuario" name="telf_usuario">
            <span class="error-message" id="error_telf"></span>
        </div>

        <div class="mb-3">
            <label for="dni_usuario" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni_usuario" name="dni_usuario">
            <span class="error-message" id="error_dni"></span>
        </div>

        <div class="mb-3">
            <label for="rol_usuario" class="form-label">Rol</label>
            <select class="form-select" id="rol_usuario" name="rol_usuario">
                <option value="Admin">Administrador</option>
                <option value="Alumno">Alumno</option>
                <option value="Profesor">Profesor</option>
                <span class="error-message" id="error_rol"></span>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Insertar Usuario</button>
    </form>
</div>
<script type="text/javascript" src="../validacionesJS/validaInsert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
