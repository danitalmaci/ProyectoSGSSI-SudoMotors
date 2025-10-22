<?php
session_start();

// Datos de conexión a la base de datos
include 'connection.php';

if (!isset($_GET['matricula'])) {
    header("Location: items.php");
    exit;
}

$matricula = $_GET['matricula'];
$errors = [];

// Buscar los datos del vehículo
$query = mysqli_query($conn, "SELECT * FROM VEHICULO WHERE MATRICULA='$matricula'");
$notFound = (!$query || mysqli_num_rows($query) == 0);
$vehiculo_data = $notFound ? null : mysqli_fetch_assoc($query);

// Actualizar los datos del vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_matricula = $_POST['matricula'] ?? '';
    $new_marca     = $_POST['marca'] ?? '';
    $new_modelo    = $_POST['modelo'] ?? '';
    $new_ano       = $_POST['ano'] ?? '';
    $new_kms       = $_POST['kms'] ?? '';

    // Comprobar si ya existe otro coche con la misma matrícula
    $check_vehiculo = mysqli_query(
        $conn,
        "SELECT * FROM VEHICULO WHERE MATRICULA='$new_matricula' AND MATRICULA <> '$matricula'"
    );
    if ($check_vehiculo && mysqli_num_rows($check_vehiculo) > 0) {
        $errors['matricula'] = "La matrícula ya existe.";
    }

    if (empty($errors)) {
        $sql = "UPDATE VEHICULO SET 
                    MATRICULA='$new_matricula',
                    MARCA='$new_marca',
                    MODELO='$new_modelo',
                    ANO='$new_ano',
                    KMS='$new_kms'
                WHERE MATRICULA='$matricula'";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("Location: show_item.php?matricula=" . urlencode($new_matricula) . "&success=1");
            exit;
        } else {
            $errors['general'] = "Error al actualizar el vehículo: " . mysqli_error($conn);
        }
    } else {
        // Si hay errores, mantenemos los datos introducidos en el form
        $vehiculo_data = [
            'MATRICULA' => $new_matricula,
            'MARCA'     => $new_marca,
            'MODELO'    => $new_modelo,
            'ANO'       => $new_ano,
            'KMS'       => $new_kms,
        ];
    }
}

$conn->close();

// Título y head
$pageTitle = "Modificar vehículo - SudoMotors";
include("includes/head.php");
?>

<nav style="display:flex; justify-content:flex-end; gap:1rem; margin-bottom:1rem;">
  <a href="items.php">Mostrar vehículos</a>
  <?php if (!empty($_SESSION['username'])): ?>
    <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil</a>
  <?php endif; ?>
</nav>

<hgroup>
  <h1>Modificar datos del vehículo</h1>
  <h3>Actualiza la información y guarda los cambios</h3>
</hgroup>

<?php if (!empty($errors['general'])): ?>
  <article role="alert"><strong><?= htmlspecialchars($errors['general']) ?></strong></article>
<?php endif; ?>

<?php if ($notFound): ?>
  <article role="alert"><strong>Vehículo no encontrado.</strong></article>
  <button type="button" onclick="window.location.href='items.php'">Volver</button>
  <?php include("includes/footer.php"); exit; ?>
<?php endif; ?>

<form id="item_modify_form" method="post" action="">
  <label>Matrícula
    <input
      type="text"
      name="matricula"
      required
      placeholder="1111 ZZZ"
      value="<?= htmlspecialchars($vehiculo_data['MATRICULA']) ?>"
    >
    <?php if (isset($errors['matricula'])): ?>
      <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['matricula']) ?></span>
    <?php endif; ?>
  </label>

  <label>Marca
    <input type="text" name="marca" required value="<?= htmlspecialchars($vehiculo_data['MARCA']) ?>">
  </label>

  <label>Modelo
    <input type="text" name="modelo" required value="<?= htmlspecialchars($vehiculo_data['MODELO']) ?>">
  </label>

  <label>Año
    <input type="text" name="ano" required value="<?= htmlspecialchars($vehiculo_data['ANO']) ?>">
  </label>

  <label>Kilómetros
    <input type="text" name="kms" required value="<?= htmlspecialchars($vehiculo_data['KMS']) ?>">
  </label>

  <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:0.75rem;">
    <button type="button" id="item_modify_submit">Guardar cambios</button>
    <button type="button" onclick="window.location.href='show_item.php?matricula=<?= urlencode($vehiculo_data['MATRICULA']) ?>'">
      Cancelar
    </button>
  </div>
</form>

<script src="js/comprobacionVehiculo.js"></script>

<?php include("includes/footer.php"); ?>
