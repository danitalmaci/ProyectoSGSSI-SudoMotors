<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


?>