<?php
session_start();
include_once '../db/conexion.php';

$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
$password = mysqli_real_escape_string($conn, $_POST['pwd']);
$_SESSION['usuario'] = $usuario;

try {
    // Prepare the SQL statement
    $sql = "SELECT * FROM tbl_usuario WHERE nombre_usuario = ? AND password_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if exactly one row is returned
    if (mysqli_num_rows($result) === 1) { 
        // Fetch the row
        $fila = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['nombre_completo'] = $fila['nombre_completo'];  // Correctly fetch the 'nombre_completo'
        $_SESSION['usuario_id'] = $fila['id_usuario'];
        
        // Check the user's role and redirect accordingly
        if ($fila['rol_usuario'] === 'Admin') {
            $_SESSION['rol'] = $fila['rol_usuario'];
            header('Location: ../entradas/leerEscuela.php');
        } elseif ($fila['rol_usuario'] === 'Profesor') {
            $_SESSION['rol'] = $fila['rol_usuario'];
            header('Location: ../entradas/leerAlumnos.php');
        } elseif ($fila['rol_usuario'] === 'Alumno') {
            $_SESSION['rol'] = $fila['rol_usuario'];
            header('Location: ../entradas/leerNotas.php');
        }
    } else {
        // If no matching user found, redirect with error
        header("Location: ../index.php?error=1");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
}
?>
