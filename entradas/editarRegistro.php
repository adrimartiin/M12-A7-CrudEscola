<?php
session_start();
include_once('../db/conexion.php');

if (!isset($conn)) {
    die("Error: La conexión a la base de datos no se estableció.");
}

// Recuperar el ID del usuario
$userId = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

if ($userId <= 0) {
    echo "<h6>ID de usuario no válido.</h6>";
    exit;
}

// Inicializar variables
$nombre_usuario = $password_usuario = $email_usuario = $telf_usuario = $dni_usuario = $rol_usuario = "";

// Obtener datos del usuario
try {
    $sql = "SELECT nombre_usuario, password_usuario, email_usuario, telf_usuario, dni_usuario, rol_usuario FROM tbl_usuario WHERE id_usuario = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($result);

        if ($usuario) {
            $nombre_usuario = $usuario['nombre_usuario'];
            $password_usuario = $usuario['password_usuario'];
            $email_usuario = $usuario['email_usuario'];
            $telf_usuario = $usuario['telf_usuario'];
            $dni_usuario = $usuario['dni_usuario'];
            $rol_usuario = $usuario['rol_usuario'];
        } else {
            echo "<h6>Usuario no encontrado.</h6>";
            exit;
        }
    } else {
        echo "<h6>Error al preparar la consulta.</h6>";
        exit;
    }
} catch (Exception $e) {
    echo "<h6>Error: " . htmlspecialchars($e->getMessage()) . "</h6>";
    exit;
}

// Actualizar datos del usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nuevo_nombre_usuario = $_POST['nombre_usuario'];
    $nueva_password_usuario = $_POST['password_usuario'];
    $nuevo_email_usuario = $_POST['email_usuario'];
    $nuevo_telf_usuario = $_POST['telf_usuario'];
    $nuevo_dni_usuario = $_POST['dni_usuario'];
    $nuevo_rol_usuario = $_POST['rol_usuario'];

    $sql_update = "UPDATE tbl_usuario SET nombre_usuario = ?, email_usuario = ?, telf_usuario = ?, dni_usuario = ?, rol_usuario = ?";

    // Si hay una nueva contraseña, añadirla a la consulta
    if (!empty($nueva_password_usuario)) {
        $password_hash = password_hash($nueva_password_usuario, PASSWORD_BCRYPT);
        $sql_update .= ", password_usuario = ?";
    }

    $sql_update .= " WHERE id_usuario = ?";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql_update)) {
        if (!empty($nueva_password_usuario)) {
            mysqli_stmt_bind_param($stmt, "ssssisi", $nuevo_nombre_usuario, $nuevo_email_usuario, $nuevo_telf_usuario, $nuevo_dni_usuario, $nuevo_rol_usuario, $password_hash, $userId);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssii", $nuevo_nombre_usuario, $nuevo_email_usuario, $nuevo_telf_usuario, $nuevo_dni_usuario, $nuevo_rol_usuario, $userId);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "<h6>Datos actualizados exitosamente.</h6>";
            header('Location: ./leerEscuela.php');
            exit();
        } else {
            echo "<h6>Error al actualizar los datos.</h6>";
        }
    } else {
        echo "<h6>Error al preparar la consulta de actualización.</h6>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Perfil</title>
</head>
<body>
<div class="container">
    <h2>Editar Perfil</h2>
    <form action="editarRegistro.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($userId); ?>">
        
        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" value="<?php echo htmlspecialchars($nombre_usuario); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="telf_usuario" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telf_usuario" id="telf_usuario" value="<?php echo htmlspecialchars($telf_usuario); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email_usuario" class="form-label">Email</label>
            <input type="email" class="form-control" name="email_usuario" id="email_usuario" value="<?php echo htmlspecialchars($email_usuario); ?>" required>
        </div>

        <div class="mb-3">
            <label for="dni_usuario" class="form-label">DNI</label>
            <input type="text" class="form-control" name="dni_usuario" id="dni_usuario" value="<?php echo htmlspecialchars($dni_usuario); ?>" required>
        </div>

        <div class="mb-3">
            <label for="rol_usuario" class="form-label">Rol de Usuario</label>
            <select class="form-select" name="rol_usuario" id="rol_usuario" required>
                <option value="admin" <?php echo $rol_usuario === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                <option value="user" <?php echo $rol_usuario === 'user' ? 'selected' : ''; ?>>Usuario</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password_usuario" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" class="form-control" id="password_usuario" name="password_usuario" placeholder="Dejar en blanco si no quieres cambiarla">
        </div>

        <button type="submit" name="update" class="btn btn-primary">Guardar Cambios</button>
        <a href="leerEscuela.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
