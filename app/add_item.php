<?php
// ------------------------------------------------------------
// Formulario para añadir Vehículo
// ------------------------------------------------------------

include 'connection.php';
session_start(); 
  
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Guardar todos los campos del formulario en variables
    $matricula   = $_POST['matricula'] ?? '';
    $marca       = $_POST['marca'] ?? '';
    $modelo      = $_POST['modelo'] ?? '';
    $anio        = $_POST['ano'] ?? '';
    $kilometros  = $_POST['kms'] ?? '';

    // Comprobar si ya existe la matrícula del vehiculo a añadir
    $check_vehiculo = mysqli_query($conn, "SELECT MATRICULA FROM VEHICULO WHERE MATRICULA = '$matricula'");
    if ($check_vehiculo && mysqli_num_rows($check_vehiculo) > 0) {
        $errors['matricula'] = "Ya existe un vehículo con esta matrícula.";
    }

    // Insertar vehículo si no hay errores
    if (empty($errors)) {
        $insertSql = "INSERT INTO VEHICULO (MATRICULA, MARCA, MODELO, ANO, KMS)
                      VALUES ('$matricula','$marca','$modelo','$anio','$kilometros')";
        $result = mysqli_query($conn, $insertSql);

        if ($result) {
        	// Si no hay errores se vuelve al listado de vehiculos
            header("Location: items.php?success=1");
            exit;
        } else {
        	// Si existe algún error se muestra el mensaje del error por pantalla
            $message = "Error al insertar vehículo: " . mysqli_error($conn);
        }
    }
}

$conn->close();

// Título y head
$pageTitle = "Añadir vehículo - SudoMotors";
include("includes/head.php");
?>

<nav style="display:flex; justify-content:flex-end; gap:1rem; margin-bottom:1rem;">
  <a href="items.php">Mostrar vehículos</a>
  <?php if (!empty($_SESSION['username'])): ?>
    <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil</a>
  <?php endif; ?>
</nav>

<hgroup>
  <h1>Añadir nuevo vehículo</h1>
  <h3>Rellena los datos y guarda</h3>
</hgroup>

<?php if (!empty($message)): ?>
  <article role="alert"><strong><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></strong></article>
<?php endif; ?>

<form id="item_add_form" method="POST" action="">
  <label>Matrícula
    <input type="text" name="matricula" required placeholder="1111 ZZZ">
    <?php if (isset($errors['matricula'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['matricula']); ?></span>
    <?php endif; ?>
  </label>

  <label>Marca
    <input type="text" name="marca">
    <?php if (isset($errors['marca'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['marca']); ?></span>
    <?php endif; ?>
  </label>

  <label>Modelo
    <input type="text" name="modelo">
    <?php if (isset($errors['modelo'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['modelo']); ?></span>
    <?php endif; ?>
  </label>

  <label>Año
    <input type="text" name="ano">
    <?php if (isset($errors['ano'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['ano']); ?></span>
    <?php endif; ?>
  </label>

  <label>Kilómetros
    <input type="text" name="kms">
    <?php if (isset($errors['kms'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['kms']); ?></span>
    <?php endif; ?>
  </label>

  <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:0.75rem;">
    <button type="button" id="item_add_submit">Guardar vehículo</button>
    <button type="button" onclick="window.location.href='items.php'">Cancelar</button>
  </div>
</form>

<script src="js/comprobacionVehiculo.js"></script>

<?php include("includes/footer.php"); ?>
