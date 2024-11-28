<?php
// crearNota.php

// Inicia la sesión
session_start();

// Verifica si el usuario está logueado y tiene rol de profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Profesor') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once "../db/conexion.php";

// Consulta para obtener todos los alumnos
$sql_alumnos = "SELECT id_usuario, nombre_usuario FROM tbl_usuario WHERE rol_usuario = 'Alumno'";
$result_alumnos = mysqli_query($conn, $sql_alumnos);

// Consulta para obtener todas las materias
$sql_materias = "SELECT id_materia, nombre_materia FROM tbl_materias";
$result_materias = mysqli_query($conn, $sql_materias);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nota</title>
    <link rel="stylesheet" href="../css/crearNota.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Crear Nueva Nota</h1>
            <nav>
                <a href="leerAlumnos.php" class="btn-volver">Volver a la lista de alumnos</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Formulario para añadir una nueva nota</h2>
            <form method="POST" action="../queries/insertarNota.php">
                <label for="alumno">Seleccionar Alumno:</label>
                <select name="alumno" id="alumno" required>
                    <option value="">Seleccione un alumno</option>
                    <?php while ($row = mysqli_fetch_assoc($result_alumnos)): ?>
                        <option value="<?php echo $row['id_usuario']; ?>"><?php echo htmlspecialchars($row['nombre_usuario']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="materia">Seleccionar Materia:</label>
                <select name="materia" id="materia" required>
                    <option value="">Seleccione una materia</option>
                    <?php while ($row = mysqli_fetch_assoc($result_materias)): ?>
                        <option value="<?php echo $row['id_materia']; ?>"><?php echo htmlspecialchars($row['nombre_materia']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="nota">Nota:</label>
                <input type="number" name="nota" id="nota" required min="0" max="10" step="0.1">

                <button type="submit" class="btn-submit">Añadir Nota</button>
            </form>
        </div>
    </main>
</body>
</html>

<?php
// Cierra la conexión
mysqli_close($conn);
?>
