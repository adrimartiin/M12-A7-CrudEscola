<?php
session_start();

// Verifica si el usuario está logueado y tiene rol de alumno
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Alumno') {
    header("Location: ../index.php");
    exit();
}

require_once "../db/conexion.php";

$alumno_id = $_SESSION['usuario_id'];

// Consulta para obtener las notas del alumno
$sql = "SELECT m.nombre_materia AS asignatura, n.nota_alumno_materia AS nota
        FROM tbl_notas n
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE n.id_usuario = '$alumno_id'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Consulta para calcular la media final del alumno
$sqlMedia = "SELECT ROUND(AVG(nota_alumno_materia), 2) AS media_final
             FROM tbl_notas
             WHERE id_usuario = '$alumno_id'";
$mediaResult = mysqli_query($conn, $sqlMedia);
$mediaFinal = mysqli_fetch_assoc($mediaResult)['media_final'];

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <p>Bienvenido/a <?php echo isset($_SESSION['nombre_completo']) ? $_SESSION['nombre_completo'] : 'Usuario no autenticado'; ?></p>
            </a>
            <div class="d-flex">
                <a href="../queries/logout.php" class="btn btn-outline-light ms-auto">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2>Mis Notas</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Asignatura</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['asignatura']); ?></td>
                                <td><?php echo htmlspecialchars($row['nota']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <!-- Fila para la media final -->
                        <tr class="table-success">
                            <td><strong>Media Final</strong></td>
                            <td><strong><?php echo $mediaFinal; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No tienes notas registradas.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
