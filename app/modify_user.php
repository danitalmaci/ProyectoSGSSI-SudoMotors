<?php session_start();
// ------------------------------------------------------------
// Formulario para modificar Usuario
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Comprobar si el usuario está identificado
if (!isset($_SESSION['username'])) {
	// Si no está identificado le lleva a la página de iniciar sesión
   	header("Location: login.php");
    exit;
}

// Buscar los datos del usuario
$query = mysqli_query($conn, "SELECT * FROM USUARIO WHERE USERNAME='" . $_SESSION['username'] . "'");

// En caso de no encontrar al usuario, lo notifica
if (!$query || mysqli_num_rows($query) === 0) {
    echo "Usuario no encontrado.";
    exit;
}

// Se guardan los datos actuales del vehículo
$user_data = mysqli_fetch_assoc($query);

// Actualizar los datos del usuairo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Recoger los datos nuevos del usuario a partir del formulario
	$new_dni = $_POST['dni'];
    $new_nombre = $_POST['nombre'];
    $new_apellidos = $_POST['apellidos'];
    $new_telefono = $_POST['telefono'];
    $new_email = $_POST['email'];
    $new_f_nacimiento = $_POST['f_nacimiento'];
    $new_contrasena = $_POST['contrasena'];
    $confirm_contrasena = $_POST['confirmar_contrasena'];
    $new_username = $_POST['username'];
    	
    // Comprobar coincidencia de contraseñas
  	if ($new_contrasena !== $confirm_contrasena) {
    		$errors['confirmar_contrasena'] = "Las contraseñas no coinciden.";
	}

	// Se comprueba si el DNI nuevo está ya en uso
	$check_dni = mysqli_query($conn, "SELECT * FROM USUARIO WHERE DNI='$new_dni' AND USERNAME != '" . $_SESSION['username'] . "'");

	// Si el DNI esta en uso se notifica del error
	if (mysqli_num_rows($check_dni) > 0) {
    		echo "<p style='color:red;'>Error: Ya existe un usuario con ese DNI.</p>";
	} 
	// Si no existe, entonces se actualizan los datos
	else {
   		$sql = "UPDATE USUARIO SET 
        		NOMBRE='$new_nombre',
            	APELLIDOS='$new_apellidos',
            	TELEFONO='$new_telefono',
            	EMAIL='$new_email',
            	F_NACIMIENTO='$new_f_nacimiento',
            	CONTRASENA='$new_contrasena',
            	USERNAME='$new_username',
            	DNI='$new_dni'
            	WHERE USERNAME='" . $_SESSION['username'] . "'";
		
		// Se ejecuta la operación y se almacena el resultado de la misma
    	$result = mysqli_query($conn, $sql);
		
		// Se actualiza el username en la variable de sesión y se redirije a la página para visualizar los datos del usuario
    	$_SESSION['username'] = $new_username;
    	header("Location: show_user.php?user=" . urlencode($new_username));
    	exit;
    	}
}

// Cerrar conexión con la base de datos
$conn->close();

// Título de la página
$pageTitle = "Registro - SudoMotors";
include("includes/head.php");
?>

// HTML
<!DOCTYPE html>
<html>
<head>
    <title>Modificar usuario</title>
</head>
	
<body>
	<div style="position: absolute; top: 20px; right: 20px;">
    	<a href="items.php">Inicio </a><br>
	</div>

	// Sutbítulo
	<h1>Modificar tus datos</h1>

	// Formulario para la modificación de parámetros
	<form id="user_modify_form" method="post">
		<label>Username:</label>
    	<input type="text" name="username" value="<?= htmlspecialchars($user_data['USERNAME']) ?>" required><br>
    	
    	<label>Contraseña:</label>
		<div style="display:flex; align-items:center; gap:10px;">
    		<input type="password" name="contrasena" id="contrasena" value="<?= htmlspecialchars($user_data['CONTRASENA']) ?>" required>
    		<label><input type="checkbox" id="togglePass"> Mostrar</label>
		</div><br>

		<label>Confirmar contraseña:</label>
		<input type="password" name="confirmar_contrasena" id="confirmar_contrasena" value="<?= htmlspecialchars($user_data['CONTRASENA']) ?>" required><br>

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
		<button type="button" onclick="window.location.href='show_user.php?user=<?= urlencode($_SESSION['username']) ?>'">
    		Cancelar
		</button>
	</form>

	// Ejecutar el js para la validación de datos
	<script src="js/comprobacionDatos.js"></script>

	// Botón para ver contraseñas
	<script>
  		const pass1 = document.getElementById('contrasena');
  		const pass2 = document.getElementById('confirmar_contrasena');
  		const toggle = document.getElementById('togglePass');

  		toggle.addEventListener('change', () => {
    		const type = toggle.checked ? 'text' : 'password';
    		pass1.type = type;
    		pass2.type = type;
  		});
	</script>

</body>

</html>

<?php include("includes/footer.php"); ?>

