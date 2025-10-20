<?php	
// ------------------------------------------------------------
// Ver información del vehiculo	
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

$vehiculos_html = "";

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];


	$sql = "SELECT * FROM VEHICULO WHERE MATRICULA = '$matricula'";
	$result = $conn->query($sql);

	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$vehiculos_html .= '
		<table border="1" cellspacing="0" cellpadding="5">
		    <tr><th>Marca</th><td>' . $row["MARCA"] . '</td></tr>
		    <tr><th>Modelo</th><td>' . $row["MODELO"] . '</td></tr>
		    <tr><th>Matrícula</th><td>' . $row["MATRICULA"] . '</td></tr>
		    <tr><th>Año</th><td>' . $row["ANO"] . '</td></tr>
		    <tr><th>Kilómetros</th><td>' . $row["KMS"] . '</td></tr>
		</table>
		';
	} else {
   		 echo "No se encontró información del vehículo.";
	}
}

$successMessage = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Los datos del vehículo se han actualizado correctamente";
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Información del vehículo</title>
</head>
<body>
<div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px;">
	<a href="items.php">Mostrar vehículos </a><br>
	<a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil </a><br>
</div>
	<h1>Datos del vehículo seleccionado</h1>
	<?php if($successMessage): ?>
        	<p style="color:green; font-weight:bold;"><?= htmlspecialchars($successMessage) ?></p>
    	<?php endif; ?>

<?php echo $vehiculos_html; ?>
<div style="margin-top: 20px;">
    <div style="display: flex; gap: 10px;">
        <form action="modify_item.php" method="get" style="margin: 0;">
            <input type="hidden" name="matricula" value="<?= htmlspecialchars($row['MATRICULA']) ?>">
            <button type="submit">Modificar Datos</button>
        </form>

        <form action="delete_item.php" method="get" style="margin: 0;">
            <input type="hidden" name="matricula" value="<?= htmlspecialchars($row['MATRICULA']) ?>">
            <button type="submit">Eliminar Vehículo</button>
        </form>
    </div>

    <div style="margin-top: 10px;">
        <button type="button" onclick="window.location.href='items.php'">
            Cancelar
        </button>
    </div>
</div>
</body>
</html>
