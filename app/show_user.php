<?php
// ------------------------------------------------------------
// Ver Perfil
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

$user=$_GET['user'] ?? 'Unknown';

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($fullname) ?></title>
</head>
<body>
    <h1>Perfil de <?= htmlspecialchars($fullname) ?></h1>

    <p><strong>Usuario:</strong> <?= htmlspecialchars($user['USERNAME']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['EMAIL']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($user['TELEFONO']) ?></p>
    <p><strong>DNI:</strong> <?= htmlspecialchars($user['DNI']) ?></p>

    <a href="modify_user.php?user=<?= urlencode($user['USERNAME']) ?>">Modificar </a><br>

    <p><a href="login.php">Volver al login</a></p>
</body>
</html>

<?php
$conn->close();
?>
