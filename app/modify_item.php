<?php session_start();
// ------------------------------------------------------------
// Formulario para modificar vehiculo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Comprobar que se ha pasasdo la matricula correctamente
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
		
	// Buscar los datos del usuario
	$query = mysqli_query($conn, "SELECT * FROM VEHICULO WHERE MATRICULA='$matricula'");

	if (!$query || mysqli_num_rows($query) < 0) {
			echo "Vehiculo no encontrado.";
			exit;
	}

	$vehiculo_data = mysqli_fetch_assoc($query);

	// Actualizar los datos del vehiculo
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$new_matricula = $_POST['matricula'];
			$new_marca = $_POST['marca'];
			$new_modelo = $_POST['modelo'];
			$new_ano = $_POST['ano'];
			$new_kms = $_POST['kms'];

			$sql = "UPDATE VEHICULO SET 
		    	MATRICULA='$new_matricula',
		    	MARCA='$new_marca',
		    	MODELO='$new_modelo',
		    	ANO='$new_ano',
		    	KMS='$new_kms'
		    	WHERE MATRICULA='$matricula";

		$result = mysqli_query($conn, $sql);
		
	   	header("Location: show_item.php?item=" . urlencode($new_matricula));
			exit;
	}
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    	<title>Modificar datos del vehiculo</title>
</head>
<body>
<h1>Modificar datos del vehiculo</h1>
<form id="item_modify_form" method="post">
		<label>Matricula:</label>
    	<input type="text" name="matricula" value="<?= htmlspecialchars($vehiculo_data['MATRICULA']) ?>" required><br>
    	
    	<label>Marca:</label>
    	<input type="text" name="marca" value="<?= htmlspecialchars($vehiculo_data['MARCA']) ?>" required><br>
    	
    	<label>Modelo:</label>
    	<input type="text" name="modelo" value="<?= htmlspecialchars($vehiculo_data['MODELO']) ?>" required><br>
    	
    	<label>Kilómetros:</label>
    	<input type="text" name="kms" min="0" value="<?= htmlspecialchars($vehiculo_data['KMS']) ?>" required><br>
    	
    	<label>Año:</label>
    	<input type="text" name="ano" min="1800" value="<?= htmlspecialchars($vehiculo_data['ANO']) ?>" required><br>

	<button type="button" id="item_modify_submit">Guardar cambios</button>
</form>

<script src="js/comprobacionVehiculo.js"></script>

</body>
</html>
