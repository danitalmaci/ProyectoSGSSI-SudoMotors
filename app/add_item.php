<?php
// ------------------------------------------------------------
// Formulario para añadir Vehículo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';
// Comienzo de sesión
session_start();

// Variable para mensajes de error o éxito
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula   = $_POST['matricula'] ?? '';
    $marca       = $_POST['marca'] ?? '';
    $modelo      = $_POST['modelo'] ?? '';
    $anio        = $_POST['ano'] ?? '';
    $kilometros  = $_POST['kms'] ?? '';

	
    // Comprobar si ya existe matrícula
    $check_vehiculo = mysqli_query($conn, "SELECT MATRICULA FROM VEHICULO WHERE MATRICULA = '$matricula'");
    
    $errors = [];
	if(mysqli_num_rows($check_vehiculo) > 0) $errors['matricula'] = "Ya existe un vehículo con esta matrícula.";

    // Insertar vehículo si no hay errores
    if (empty($errors)) {
    	$insertSql = "INSERT INTO VEHICULO (MATRICULA, MARCA, MODELO, ANO, KMS) VALUES ('$matricula','$marca','$modelo','$anio','$kilometros')";
    	
		$result = mysqli_query($conn, $insertSql);
	   	header("Location: items.php");
		exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir vehículo</title>
</head>
<body>
<div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px;">
    <a href="items.php">Mostrar vehículos</a><br>
    <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil</a><br>
</div>

<h1>Añadir nuevo vehículo</h1>

<?php if (!empty($message)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form id="item_add_form" method="POST" action="">
    <label>Matrícula:<br>
        <input type="text" name="matricula" required placeholder="1111 ZZZ" >
        <?php if (isset($errors['matricula'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['matricula']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Marca:<br>
        <input type="text" name="marca">
        <?php if (isset($errors['marca'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['marca']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Modelo:<br>
        <input type="text" name="modelo">
        <?php if (isset($errors['modelo'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['modelo']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Año:<br>
        <input type="text" name="ano" >
        <?php if (isset($errors['ano'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['ano']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Kilómetros:<br>
        <input type="text" name="kms" >
        <?php if (isset($errors['kms'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['kms']); ?></span>
        <?php endif; ?>
    </label><br><br>

    <button type="button" id="item_add_submit" >Guardar vehículo</button>
    <button type="button" onclick="window.location.href='items.php'">Cancelar</button>
</form>

<script src="js/comprobacionVehiculo.js"></script>
</body>
</html>
