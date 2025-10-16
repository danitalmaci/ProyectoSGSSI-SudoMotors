<?php
$hostname = "db";
$bdusername = "admin";
$password = "test";
$db = "database";

// Crear la conexión con la base de datos
$conn = mysqli_connect($hostname, $username, $password, $db);

// Verificar la conexión
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


?>
