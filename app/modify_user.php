<?php
include 'connection.php';

// Comprobar si el usuario está identificado
if (!isset($_SESSION['user_id'])) {
	// Si no está identificado le lleva a la página de iniciar sesión
   	header("Location: login.php");
    	exit;
}

$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

// Obtener el ID de usuario
$user_id = $_GET['user'] ?? '';
if ($user_id != $_SESSION['user_id']) {
    	echo "Error: Solo puedes modificar tus propios datos.";
    	exit;
}

// Buscar los datos del usuario
$query = mysqli_query($conn, "SELECT * FROM USUARIOS WHERE id='$user_id'");
if (!$query || mysqli_num_rows($query) != 1) {
    	echo "Usuario no encontrado.";
    	exit;
}

$user_data = mysqli_fetch_assoc($query);

// Actualizar los datos del usuairo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$new_username = mysqli_real_escape_string($conn, $_POST['username']);
    	$new_email = mysqli_real_escape_string($conn, $_POST['email']);

    	mysqli_query($conn, "UPDATE USUARIOS SET nombre='$new_username', email='$new_email' WHERE id='$user_id'");
    	header("Location: index.php");
    	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    	<title>Modificar usuario</title>
</head>
<body>
<h1>Modificar tus datos</h1>
<form id="user_modify_form" method="post">
    	<label>Nombre:</label>
    	<input type="text" name="username" value="<?= htmlspecialchars($user_data['nombre']) ?>" required><br>

    	<label>Email:</label>
    	<input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" required><br>

    	<button id="user_modify_submit" type="submit">Guardar cambios</button>
</form>
</body>
</html>

