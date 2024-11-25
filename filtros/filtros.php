<?php
    include_once '../db/conexion.php';

    $no_resultados='';
    $filtros=[];
    $parametros=[];
    $tipos='';

    if (!empty($_GET['nombre'])) {
        $filtros[] = 'nombre_usuario LIKE ?';
        $parametros[] = '%' . $_GET['nombre'] . '%';
        $tipos .= 's';
    }
    
    if (!empty($_GET['dni'])) {
        $filtros[] = 'dni_usuario LIKE ?';
        $parametros[] = '%' . $_GET['dni'] . '%';
        $tipos .= 's';
    }
    
    if (!empty($filtros)) {
        $query = "SELECT nombre_usuario, dni_usuario FROM tbl_usuario";
    
        $query .= ' WHERE ' . implode(' AND ', $filtros);
    
        $stmt = mysqli_prepare($conn, $query);
        if ($tipos) {
            mysqli_stmt_bind_param($stmt, $tipos, ...$parametros);
        }
    
        mysqli_stmt_execute($stmt);
        $resultados = mysqli_stmt_get_result($stmt);
    
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($filtros) && mysqli_num_rows($resultados) === 0) {
            $no_resultados = "No hay resultados para los filtros seleccionados.";
        }
    } else {
        $resultados = null;
    }