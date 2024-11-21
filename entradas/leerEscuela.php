<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
</body>
</html>
<?php
session_start();

// Control de sesiones
include_once('../db/conexion.php');

if (!isset($conn)) {
    die("Error: La conexión a la base de datos no se estableció.");
}

$nombre_usuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
$email_usuario = isset($_POST['email_usuario']) ? $_POST['email_usuario'] : '';
$telf_usuario = isset($_POST['telf_usuario']) ? $_POST['telf_usuario'] : '';
$rol_usuario = isset($_POST['rol_usuario']) ? $_POST['rol_usuario'] : '';

$sql = "SELECT 
    nombre_usuario,
    email_usuario,
    telf_usuario,
    rol_usuario
    FROM 
    tbl_usuario";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-hover table-striped'>";
    echo "<thead class='table-dark'>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Rol</th>
            </tr>
          </thead>";
    echo "<tbody>";

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $rowCount = count($rows);
    for ($i = 0; $i < $rowCount; $i++) {
        echo "<tr>
                <td>" . htmlspecialchars($rows[$i]["nombre_usuario"]) . "</td>
                <td>" . htmlspecialchars($rows[$i]["email_usuario"]) . "</td>
                <td>" . htmlspecialchars($rows[$i]["telf_usuario"]) . "</td>
                <td>" . htmlspecialchars($rows[$i]["rol_usuario"]) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<p class='text-center text-warning'>No hay resultados que coincidan con los filtros aplicados.</p>";
}
$conn->close();
?>
