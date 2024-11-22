<?php
session_start();

include_once('../db/conexion.php');

if (!isset($conn)) {
    die("Error: La conexión a la base de datos no se estableció.");
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); 

    try {
        mysqli_begin_transaction($conn);

        $sqlDeleteNotas = "DELETE FROM tbl_notas WHERE id_usuario = ?";
        $stmtNotas = mysqli_prepare($conn, $sqlDeleteNotas);
        mysqli_stmt_bind_param($stmtNotas, 'i', $userId);
        mysqli_stmt_execute($stmtNotas);

        $sqlDeleteUsuario = "DELETE FROM tbl_usuario WHERE id_usuario = ?";
        $stmtUsuario = mysqli_prepare($conn, $sqlDeleteUsuario);
        mysqli_stmt_bind_param($stmtUsuario, 'i', $userId);
        mysqli_stmt_execute($stmtUsuario);

        mysqli_commit($conn);

        header("Location: leerEscuela.php?UsuarioEliminado");
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: leerEscuela.php?error=operacion_fallida");
    }
} else {
    header("Location: leerEscuela.php?error=id_no_proporcionado");
}

mysqli_close($conn);
?>
