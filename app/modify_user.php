<?php session_start();
include 'connection.php';

// Comprobar si el usuario está identificado
if (!isset($_SESSION['usuario'])) {
	// Si no está identificado le lleva a la página de iniciar sesión
   	header("Location: login.php");
    	exit;
}

// Buscar los datos del usuario
$query = mysqli_query($conn, "SELECT * FROM USUARIO WHERE USUARIO='" . $_SESSION['usuario'] . "'");

if (!$query || mysqli_num_rows($query) < 0) {
    	echo "Usuario no encontrado.";
    	exit;
}

$user_data = mysqli_fetch_assoc($query);

// Actualizar los datos del usuairo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$new_dni = $_POST['dni'];
    	$new_nombre = $_POST['nombre'];
    	$new_apellidos = $_POST['apellidos'];
    	$new_telefono = $_POST['telefono'];
    	$new_email = $_POST['email'];
    	$new_f_nacimiento = $_POST['f_nacimiento'];
    	$new_contrasena = $_POST['contrasena'];
    	$new_usuario = $_POST['usuario'];

    	mysqli_query($conn, "UPDATE USUARIO SET NOMBRE='$new_nombre', APELLIDOS='$new_apellidos', TELEFONO='$new_telefono', EMAIL='$new_email', 
    						F_NACIMIENTO='$new_f_nacimiento', CONTRASENA='$new_contrasena', USUARIO='$new_usuario' 
    						WHERE USUARIO='" . $_SESSION['usuario'] . "'");


	$_SESSION['usuario'] = $new_usuario;
    	header("Location: show_user.php?user=" . urlencode($new_usuario));
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
	<label>Usuario:</label>
    	<input type="text" name="usuario" value="<?= htmlspecialchars($user_data['USUARIO']) ?>" required><br>
    	
    	<label>Contraseña:</label>
    	<input type="password" name="contrasena" value="<?= htmlspecialchars($user_data['CONTRASENA']) ?>" required><br>
    	
    	<label>Nombre:</label>
    	<input type="text" name="nombre" value="<?= htmlspecialchars($user_data['NOMBRE']) ?>" required><br>

    	<label>Apellidos:</label>
    	<input type="text" name="apellidos" value="<?= htmlspecialchars($user_data['APELLIDOS']) ?>" required><br>
    	
    	<label>DNI:</label>
    	<input type="text" name="dni" value="<?= htmlspecialchars($user_data['DNI']) ?>" required><br>
    	
    	<label>Email:</label>
    	<input type="email" name="email" value="<?= htmlspecialchars($user_data['EMAIL']) ?>" required><br>

    	<label>Teléfono:</label>
    	<input type="text" name="telefono" value="<?= htmlspecialchars($user_data['TELEFONO']) ?>" required><br>

	<label>Fecha de nacimiento:</label>
	<input type="date" name="f_nacimiento" value="<?= htmlspecialchars($user_data['F_NACIMIENTO']) ?>" required><br>

	<button type="button" id="user_modify_submit">Guardar cambios</button>
</form>

<script src="js/comprobacionDatos.js"></script>

</body>

</html>

