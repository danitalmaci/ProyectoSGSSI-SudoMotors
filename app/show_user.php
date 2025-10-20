<?php session_start();
// ------------------------------------------------------------
// Ver Perfil
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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

$successMessage = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Tus datos se han actualizado correctamente";
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
    	<a href="items.php">Mostrar vehículos </a><br>
</div>
    <h1>Perfil de <?= htmlspecialchars($fullname) ?></h1>
    <?php if($successMessage): ?>
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>

    <p><strong>Usuario:</strong> <?= htmlspecialchars($user['USERNAME']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['EMAIL']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($user['TELEFONO']) ?></p>
    <p><strong>DNI:</strong> <?= htmlspecialchars($user['DNI']) ?></p>
    
    <div style="margin-top: 20px;">
    <div style="display: flex; gap: 10px;">
        <form action="modify_user.php" method="get" style="margin: 0;">
        	<input type="hidden" name="username" value="<?= urlencode($user['USERNAME']) ?>">
        	<button type="submit">Modificar Datos</button>
    	</form>

        <button type="button" onclick="window.location.href='login.php?logout=1'">
    		Cerrar sesión
    	</button>
    </div>
</div>
</body>
</html>

