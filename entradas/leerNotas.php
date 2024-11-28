<?php
// leerNotas.php

// Inicia la sesión
session_start();

// Verifica si el usuario está logueado y tiene rol de alumno
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Alumno') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once "../db/conexion.php";

// Obtiene el ID del alumno desde la sesión
$alumno_id = $_SESSION['usuario_id'];

// Establece el número de registros por página
$registros_por_pagina = 8;

// Obtiene el número de la página actual desde la URL (si no se especifica, es la página 1)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula el índice de inicio para la consulta
$inicio = ($pagina_actual - 1) * $registros_por_pagina;

// Consulta para obtener las notas del alumno con paginación
$sql = "SELECT m.nombre_materia AS asignatura, n.nota_alumno_materia AS nota
        FROM tbl_notas n
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE n.id_usuario = '$alumno_id'
        LIMIT $inicio, $registros_por_pagina";

// Ejecuta la consulta
$result = mysqli_query($conn, $sql);

// Verifica si hay resultados
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Consulta para obtener el número total de registros
$sql_total = "SELECT COUNT(*) AS total_notas
              FROM tbl_notas n
              WHERE n.id_usuario = '$alumno_id'";

$result_total = mysqli_query($conn, $sql_total);
$total_registros = mysqli_fetch_assoc($result_total)['total_notas'];

// Calcula el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Notas</title>
    <link rel="stylesheet" href="../css/leerNotas.css">
    <!-- Vincula Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
            <nav>
                <a href="../queries/logout.php" class="btn-logout">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Mis Notas</h2>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="tabla-notas table table-striped">
                    <thead>
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
                    </tbody>
                </table>

                <!-- Paginación -->
                <nav aria-label="Paginación">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina_actual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina_actual < $total_paginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

            <?php else: ?>
                <p>No tienes notas registradas.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Vincula los archivos JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


