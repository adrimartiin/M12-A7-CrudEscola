<?php
include_once '../filtros/filtros.php';
session_start();

if (isset($_GET['clear_filters'])) {
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?')); 
    exit();
}

if (!isset($_SESSION['nombre_completo'])) {
    header("Location: login.php");
    exit();
}

include_once('../db/conexion.php');

$nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
$dni = isset($_GET['dni']) ? htmlspecialchars($_GET['dni']) : '';

$registrosPorPagina = 8;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $registrosPorPagina;

$whereClause = [];
if (!empty($nombre)) {
    $whereClause[] = "nombre_usuario LIKE '%$nombre%'";
}
if (!empty($dni)) {
    $whereClause[] = "dni_usuario LIKE '%$dni%'";
}
$whereSQL = !empty($whereClause) ? "WHERE " . implode(" AND ", $whereClause) : "";

$sql = "SELECT * FROM tbl_usuario $whereSQL LIMIT $offset, $registrosPorPagina";
$result = mysqli_query($conn, $sql);

$sqlTotal = "SELECT COUNT(*) AS total FROM tbl_usuario $whereSQL";
$totalResult = mysqli_query($conn, $sqlTotal);
$totalRows = mysqli_fetch_assoc($totalResult)['total'];
$totalPaginas = ceil($totalRows / $registrosPorPagina);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand me-auto"><p>Bienvenido/a <?php echo "Bienvenido " . (isset($_SESSION['nombre_completo']) ? $_SESSION['nombre_completo'] : 'Usuario no autenticado'); ?></p></a>

        <div class="d-flex justify-content-center flex-grow-1">
            <form class="d-flex" method="get">
                <input class="form-control me-2" name="nombre" value="<?php echo $nombre; ?>" type="search" placeholder="Usuario" aria-label="Nombre" style="max-width: 200px;">
                <input class="form-control me-2" name="dni" value="<?php echo $dni; ?>" type="search" placeholder="DNI" aria-label="DNI" style="max-width: 200px;">
                <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <div class="d-flex ms-3">
            <a href="?clear_filters=1" class="btn btn-outline-danger btn-sm mx-2"><i class="fa-solid fa-trash"></i></a>
            <a href="../queries/logout.php" class="btn btn-outline-light btn-sm mx-2">Cerrar Sesión</a>
        </div>
    </div>
</nav>

    <div class="container my-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover table-striped text-center'>";
            echo "<thead class='table-dark'>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='align-middle'>
                        <td>" . htmlspecialchars($row["dni_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["nombre_completo"]) . "</td>
                        <td>" . htmlspecialchars($row["nombre_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["email_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["telf_usuario"]) . "</td>
                        <td>
                            <a href='editarRegistro.php?id=" . htmlspecialchars($row["id_usuario"]) . "' class='btn btn-warning btn-sm me-2'>Editar</a>
                            <a href='eliminarRegistro.php?id=" . htmlspecialchars($row["id_usuario"]) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";
            echo "</div>";

            // Paginación
            echo "<nav aria-label='Paginación'>";
            echo "<ul class='pagination justify-content-center'>";
            if ($paginaActual > 1) {
                echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($paginaActual - 1) . "'>Anterior</a></li>";
            }
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<li class='page-item " . ($i == $paginaActual ? "active" : "") . "'>
                        <a class='page-link' href='?pagina=$i'>$i</a>
                      </li>";
            }
            if ($paginaActual < $totalPaginas) {
                echo "<li class='page-item'><a class='page-link' href='?pagina=" . ($paginaActual + 1) . "'>Siguiente</a></li>";
            }
            echo "</ul>";
            echo "</nav>";
        } else {
            echo "<p class='text-center text-warning'>No hay resultados que coincidan con los filtros aplicados.</p>";
        }
        mysqli_close($conn);
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
