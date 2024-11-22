<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Lista de Usuarios</h1>
        <?php
        session_start();

        // falta poner control de sesiones
        include_once('../db/conexion.php');

        if (!isset($conn)) {
            die("<div class='alert alert-danger text-center'>Error: La conexión a la base de datos no se estableció.</div>");
        }

        $registrosPorPagina = 10;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($paginaActual - 1) * $registrosPorPagina;

        $sql = "SELECT 
            id_usuario,
            nombre_usuario,
            email_usuario,
            telf_usuario,
            rol_usuario
            FROM 
            tbl_usuario
            LIMIT $offset, $registrosPorPagina";

        $result = $conn->query($sql);

        // Obtener el número total de registros para calcular páginas
        $sqlTotal = "SELECT COUNT(*) AS total FROM tbl_usuario";
        $totalResult = $conn->query($sqlTotal);
        $totalRows = $totalResult->fetch_assoc()['total'];
        $totalPaginas = ceil($totalRows / $registrosPorPagina);

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover table-striped text-center'>";
            echo "<thead class='table-dark'>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                echo "<tr class='align-middle'>
                        <td>" . htmlspecialchars($row["nombre_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["email_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["telf_usuario"]) . "</td>
                        <td>" . htmlspecialchars($row["rol_usuario"]) . "</td>
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
        $conn->close();
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
