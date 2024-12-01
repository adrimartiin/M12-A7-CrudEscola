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
    <style>
        /* General styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar-brand{
            padding-right: 20px;
        }
        
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #212529; /* Oscuro */
            color: #fff;
        }

        .navbar .brand {
            font-size: 18px;
            font-weight: bold;
            margin-left:10px;
        }

        .navbar .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar input[type="text"] {
            padding: 5px;
            font-size: 14px;
        }

        .navbar button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Responsive styles */
        @media (max-width: 576px) {
            .navbar {
                flex-wrap: wrap; /* Permite dividir elementos en múltiples filas */
            }
            
            .navbar .navbar-brand {
                width: 100%; /* La marca ocupa todo el ancho */
                text-align: center;
                margin-bottom: 10px;
            }

            .navbar .search-container {
                flex-direction: column; /* Coloca los elementos uno debajo del otro */
                width: 100%;
            }

            .navbar .search-container input,
            .navbar .search-container button {
                width: 100%; /* Inputs y botón ocupan todo el ancho */
                margin-bottom: 10px; /* Espaciado entre elementos */
            }

            .navbar .actions {
                flex-direction: column; /* Botones en columna */
                width: 100%;
            }

            .navbar .actions a {
                width: 100%; /* Botones ocupan todo el ancho */
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- Marca de bienvenida -->
        <a class="navbar-brand me-auto">
            <p>Bienvenido/a <?php echo "Bienvenido " . (isset($_SESSION['nombre_completo']) ? $_SESSION['nombre_completo'] : 'Usuario no autenticado'); ?></p>
        </a>

        <!-- Contenedor de búsqueda -->
        <div class="search-container d-flex flex-column flex-md-row flex-grow-1">
            <form class="d-flex flex-column flex-md-row w-100" method="get">
                <input class="form-control mb-2 mb-md-0 me-md-2" name="nombre" value="<?php echo $nombre; ?>" type="search" placeholder="Usuario" aria-label="Nombre">
                <input class="form-control mb-2 mb-md-0 me-md-2" name="dni" value="<?php echo $dni; ?>" type="search" placeholder="DNI" aria-label="DNI">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Botones de acciones -->
        <div class="actions d-flex flex-column flex-md-row ms-md-3">
            <a href="?clear_filters=1" class="btn btn-outline-danger btn-sm mb-2 mb-md-0 me-md-2">
                <i class="fa-solid fa-trash"></i>
            </a>
            <a href="../queries/logout.php" class="btn btn-outline-light btn-sm">
                Cerrar Sesión
            </a>
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