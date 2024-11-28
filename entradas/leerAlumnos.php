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

// Consulta para obtener los alumnos, sus materias y sus notas
$sql = "SELECT u.id_usuario, u.nombre_usuario, m.nombre_materia, n.nota_alumno_materia, n.id_nota
        FROM tbl_usuario u
        INNER JOIN tbl_notas n ON u.id_usuario = n.id_usuario
        INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
        WHERE u.rol_usuario = 'Alumno'";

// Ejecuta la consulta
$result = mysqli_query($conn, $sql);

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
</head>
<body>
    <header>
        <div class="container">
            <h1>Bienvenido, Profesor <?php echo $_SESSION['usuario']; ?></h1>
            <nav>
                <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
                <a href="crearNota.php" class="btn-crear">Crear Nota</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Lista de Alumnos</h2>
            <table class="tabla-alumnos">
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
                                <a href="editarNota.php?id_nota=<?php echo $row['id_nota']; ?>" class="btn-editar">Modificar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
<?php
else:
    echo "<p>No hay alumnos registrados.</p>";
endif;

// Cierra la conexión
mysqli_close($conn);
?>

