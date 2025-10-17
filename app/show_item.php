<?php	
// ------------------------------------------------------------
// Ver información del vehiculo	
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

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

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Información vehiculo</title>
</head>
<body>
	<h1>Datos del vehículo seleccionado</h1>

<?php echo $vehiculos_html; ?>

 	<div>
 		<br>
        <form action="modify_item.php" method="get">
        	<input type="hidden" name="matricula" value="<?php echo htmlspecialchars($row['MATRICULA']); ?>">
            <button type="submit">Modificar Datos</button>
        </form>
		
		<br>
        <form action="delete_item.php" method="get">
        	<input type="hidden" name="matricula" value="<?php echo htmlspecialchars($row['MATRICULA']); ?>">
            <button type="submit">Eliminar Vehículo</button>
        </form>
    </div>


</body>
</html>
