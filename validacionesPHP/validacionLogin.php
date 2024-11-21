<?php
session_start();
include_once '../db/conexion.php';

// Recibir los datos del formulario
$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
$password = mysqli_real_escape_string($conn, $_POST['pwd']);
$_SESSION['usuario'] = $usuario;

try {
    $sql = "SELECT nombre_usuario, password_usuario FROM tbl_usuario WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Si el usuario existe, validar la contraseña
    if ($row && password_verify($password, $row['password_usuario'])) {
        $_SESSION['nombreReal_usuario'] = $row['nombre_usuario'];
        $_SESSION['rol_usuario'] = $row['rol_usuario'];

        // Verificar si el rol es 'admin'
        if ($row['rol_usuario'] === 'Admin') {
            header('Location: ../accionesAdmin/bienvenida.php');
            exit();
        }
        // } elseif($row['rol_usuario'] === 'Alumno') {
        //     // Alumno accede a su pagina con ficha de notas
        //     header('Location: ../acciones/bienvenida.php');
        //     exit();
        // }
    } else {
        $_SESSION['error']="Usuario o contraseña incorrectos";
        header('Location: ../index.php');
        exit();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
﻿