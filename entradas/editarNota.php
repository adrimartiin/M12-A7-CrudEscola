<?php
// editarNota.php

// Inicia la sesión
session_start();

// Verifica si el usuario está logueado y tiene rol de profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Profesor') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once "../db/conexion.php";

// Verifica si el parámetro id_nota está presente en la URL
if (isset($_GET['id_nota'])) {
    $id_nota = $_GET['id_nota'];

    // Consulta para obtener los datos de la nota
    $sql = "SELECT n.nota_alumno_materia, m.nombre_materia, u.nombre_usuario
            FROM tbl_notas n
            INNER JOIN tbl_materias m ON n.id_materia = m.id_materia
            INNER JOIN tbl_usuario u ON n.id_usuario = u.id_usuario
            WHERE n.id_nota = '$id_nota'";

    // Ejecuta la consulta
    $result = mysqli_query($conn, $sql);

    // Verifica si se obtuvo el registro de la nota
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nota_actual = $row['nota_alumno_materia'];
        $materia = $row['nombre_materia'];
        $alumno = $row['nombre_usuario'];
    } else {
        echo "Nota no encontrada.";
        exit();
    }
} else {
    echo "ID de nota no proporcionado.";
    exit();
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_nota = $_POST['nota'];

    // Consulta para actualizar la nota
    $update_sql = "UPDATE tbl_notas SET nota_alumno_materia = '$nueva_nota' WHERE id_nota = '$id_nota'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: leerAlumnos.php"); // Redirige de nuevo a la lista de alumnos
        exit();
    } else {
        echo "Error al actualizar la nota.";
    }
}

// Cierra la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Nota</title>
    <link rel="stylesheet" href="../css/leerAlumnos.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Modificar Nota de <?php echo htmlspecialchars($alumno); ?> - Materia: <?php echo htmlspecialchars($materia); ?></h1>
            <nav>
                <a href="leerAlumnos.php" class="btn-volver">Volver a la lista</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h2>Editar Nota</h2>
            <form method="POST">
                <label for="nota">Nota:</label>
                <input type="number" name="nota" id="nota" value="<?php echo htmlspecialchars($nota_actual); ?>" required min="0" max="10" step="0.1">
                <button type="submit" class="btn-submit">Guardar Cambios</button>
            </form>
        </div>
    </main>
<script src="../validacionesJS/validacionEditarNota.js"></script>
</body>
</html>
