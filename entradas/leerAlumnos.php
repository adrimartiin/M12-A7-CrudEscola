<?php
// leerAlumnos.php

// Inicia la sesión
session_start();

// Verifica si el usuario está logueado y tiene rol de profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Profesor') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once "../db/conexion.php";

// Configuración de la paginación
$registrosPorPagina = 6;  // Se muestran 6 registros por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $registrosPorPagina;

// Consulta para obtener los alumnos, sus materias y sus notas, ordenados por el nombre del alumno
$sql = "SELECT u.id_usuario, u.nombre_usuario, m.nombre_materia, n.nota_alumno_materia, n.id_nota
        FROM tbl_usuario u
        INNER JOIN tbl_notas n ON u.id_usuario = n.id_usuario
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE u.rol_usuario = 'Alumno'
        ORDER BY u.nombre_usuario ASC
        LIMIT $offset, $registrosPorPagina";  // Limita los registros por página

// Ejecuta la consulta
$result = mysqli_query($conn, $sql);

// Consulta para obtener el total de registros
$sqlTotal = "SELECT COUNT(*) AS total FROM tbl_usuario u
             INNER JOIN tbl_notas n ON u.id_usuario = n.id_usuario
             WHERE u.rol_usuario = 'Alumno'";
$totalResult = mysqli_query($conn, $sqlTotal);
$totalRows = mysqli_fetch_assoc($totalResult)['total'];
$totalPaginas = ceil($totalRows / $registrosPorPagina);

// Verifica si se obtuvieron resultados
if (mysqli_num_rows($result) > 0):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer Alumnos</title>
    <link rel="stylesheet" href="../css/leerAlumnos.css">
    <!-- Asegúrate de que Bootstrap esté correctamente vinculado -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenido/a, Profesor/a <?php echo $_SESSION['usuario']; ?></h1>
            <nav>
                <a href="../queries/logout.php" class="btn-logout">Cerrar Sesión</a>
                <a href="crearNota.php" class="btn-crear">Crear Nota</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Lista de Alumnos</h2>
            <table class="tabla-alumnos table table-striped">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Materia</th>
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                            <td><?php echo htmlspecialchars($row['nota_alumno_materia']); ?></td>
                            <td>
                                <!-- Botón para editar la nota -->
                                <a href="editarNota.php?id_nota=<?php echo $row['id_nota']; ?>" class="btn btn-primary">Modificar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Paginación -->
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
    </main>

    <!-- Vincula el archivo de Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
else:
    echo "<p>No hay alumnos registrados.</p>";
endif;

// Cierra la conexión
mysqli_close($conn);
?>

