<?php
// insertarNota.php

// Inicia la sesión
session_start();

// Verifica si el usuario está logueado y tiene rol de profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Profesor') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once "../db/conexion.php";

// Verifica si los datos han sido enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los valores del formulario
    $id_alumno = isset($_POST['alumno']) ? $_POST['alumno'] : '';
    $id_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
    $nota = isset($_POST['nota']) ? $_POST['nota'] : '';

    // Si los campos son válidos
    if ($id_alumno !== '' && $id_materia !== '' && $nota !== '') {
        // Consulta para insertar la nueva nota
        $insert_sql = "INSERT INTO tbl_notas (id_usuario, id_materia, nota_alumno_materia) 
                       VALUES ('$id_alumno', '$id_materia', '$nota')";

        if (mysqli_query($conn, $insert_sql)) {
            header("Location: ../entradas/leerAlumnos.php"); // Redirige a la lista de alumnos
            exit();
        } else {
            echo "Error al insertar la nota.";
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}

// Cierra la conexión
mysqli_close($conn);
?>
