<?php
$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "bd_gestio";

try {
    $conn = @mysqli_connect($dbserver, $dbusername, $dbpassword, $dbname);
}
catch (Exception $e) {
    echo "Error de conexión: ". $e->getMessage();
    die();
}