<?php
// ------------------------------------------------------------
// Ver Perfil
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Iniciar la sesion
session_start();
$user=$_SESSION['username'] ?? "unknown";

$sql="SELECT * FROM USUARIO WHERE USERNAME= '$user'";
$result=$conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullname=$user['NOMBRE'] . ' ' . $user['APELLIDOS'];
} else {
    die("Usuario no encontrado.");
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($fullname) ?></title>
</head>
<body>
<div style="position: absolute; top: 20px; right: 20px;">
    	<a href="items.php">Inicio </a><br>
</div>
    <h1>Perfil de <?= htmlspecialchars($fullname) ?></h1>

    <p><strong>Usuario:</strong> <?= htmlspecialchars($user['USERNAME']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['EMAIL']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($user['TELEFONO']) ?></p>
    <p><strong>DNI:</strong> <?= htmlspecialchars($user['DNI']) ?></p>
    
    <button type="button" onclick="window.location.href='modify_user.php?user=<?= urlencode($_SESSION['username']) ?>'">
    	Modificar
    </button>

    <button type="button" onclick="window.location.href='login.php?logout=1'">
    	Cerrar sesión
    </button>
</body>
</html>

