<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Profesor') {
    header("Location: ../index.php");
    exit();
}

require_once "../db/conexion.php";

$registrosPorPagina = 6;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $registrosPorPagina;

$sql = "SELECT u.id_usuario, u.nombre_usuario, m.nombre_materia, n.nota_alumno_materia, n.id_nota
        FROM tbl_usuario u
        INNER JOIN tbl_notas n ON u.id_usuario = n.id_usuario
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE u.rol_usuario = 'Alumno'
        ORDER BY u.nombre_usuario ASC
        LIMIT $offset, $registrosPorPagina";  
$result = mysqli_query($conn, $sql);

$sqlTotal = "SELECT COUNT(*) AS total FROM tbl_usuario u
             INNER JOIN tbl_notas n ON u.id_usuario = n.id_usuario
             WHERE u.rol_usuario = 'Alumno'";
$totalResult = mysqli_query($conn, $sqlTotal);
$totalRows = mysqli_fetch_assoc($totalResult)['total'];
$totalPaginas = ceil($totalRows / $registrosPorPagina);

if (mysqli_num_rows($result) > 0):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand">Bienvenido, Profesor <?php echo $_SESSION['usuario']; ?></a>
        
        <div class="d-flex">
            <a href="crearNota.php" class="btn btn-outline-success me-2">Crear Nota</a>

            <a href="../queries/logout.php" class="btn btn-outline-light ms-auto">Cerrar Sesión</a>
        </div>
    </div>
</nav>


    <div class="container my-5">
        <h2>Lista de Alumnos</h2>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover table-striped text-center'>
                <thead class='table-dark'>
                    <tr>
                        <th>Alumno</th>
                        <th>Materia</th>
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class='align-middle'>
                        <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                        <td><?php echo htmlspecialchars($row['nota_alumno_materia']); ?></td>
                        <td>
                            <a href="editarNota.php?id_nota=<?php echo $row['id_nota']; ?>" class="btn btn-warning btn-sm me-2"><i class="fa-solid fa-pen"></i> Modificar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Paginación">
            <ul class="pagination justify-content-center">
                <?php if ($paginaActual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?php echo ($i == $paginaActual) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($paginaActual < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
else:
    echo "<p class='text-center text-warning'>No hay alumnos registrados.</p>";
endif;

mysqli_close($conn);
?>
