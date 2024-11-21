<?php
session_start();
include_once '../db/conexion.php';

$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
$password = mysqli_real_escape_string($conn, $_POST['pwd']);
$_SESSION['usuario'] = $usuario;

try {
    $sql = "SELECT * FROM tbl_usuario WHERE nombre_usuario = ? AND password_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) { // Comprueba si el usuario y contraseña coinciden
        header("Location: ../entradas/leerEscuela.php");
    } else {
        header("Location: ../index.php?error=1");
    }

    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
