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


// Consulta para obtener las notas del alumno
$sql = "SELECT m.nombre_materia AS assignatura, n.nota_alumno_materia AS nota
        FROM tbl_notas n
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE n.id_usuario = '$alumno_id'";

// Ejecutar la consulta
$result = mysqli_query($conn, $sql);

// Verifica si hay resultados
if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

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
                <table class="tabla-notas">
                    <thead>
                        <tr>
                            <th>Asignatura</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['assignatura']); ?></td>
                                <td><?php echo htmlspecialchars($row['nota']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No tienes notas registradas.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
