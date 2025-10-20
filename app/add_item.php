<?php
session_start();
// ------------------------------------------------------------
// Formulario para añadir Vehículo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Variable para mensajes de error o éxito
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula   = $_POST['matricula'] ?? '';
    $marca       = $_POST['marca'] ?? '';
    $modelo      = $_POST['modelo'] ?? '';
    $anio        = $_POST['ano'] ?? '';
    $kilometros  = $_POST['kms'] ?? '';

    // Validación de campos obligatorios
    if (empty($matricula))  $errors['matricula'] = "Este campo es obligatorio.";
    if (empty($marca))      $errors['marca']     = "Este campo es obligatorio.";
    if (empty($modelo))     $errors['modelo']    = "Este campo es obligatorio.";
    if (empty($anio))       $errors['ano']       = "Este campo es obligatorio.";
    if (empty($kilometros)) $errors['kms']       = "Este campo es obligatorio.";

    // Comprobar si ya existe matrícula
    if (empty($errors)) {
        $checkSql = "SELECT MATRICULA FROM VEHICULO WHERE MATRICULA=?";
        $stmt = $conn->prepare($checkSql);
        if ($stmt) {
            $stmt->bind_param('s', $matricula);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows > 0) {
                $errors['matricula'] = "Ya existe un vehículo con esta matrícula.";
            }
            $stmt->close();
        } else {
            $message = "Error preparando comprobación: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
        }
    }

    // Insertar vehículo si no hay errores
    if (empty($errors)) {
        $insertSql = "INSERT INTO VEHICULO (MATRICULA, MARCA, MODELO, ANO, KMS) VALUES (?,?,?,?,?)";
        $stmt2 = $conn->prepare($insertSql);
        if ($stmt2) {
            $stmt2->bind_param('sssii', $matricula, $marca, $modelo, $anio, $kilometros);
            if ($stmt2->execute()) {
                $stmt2->close();
                $conn->close();
                header("Location: items.php?success=1");
                exit;
            } else {
                $message = "Error al insertar el vehículo: " . htmlspecialchars($stmt2->error, ENT_QUOTES, 'UTF-8');
                $stmt2->close();
            }
        } else {
            $message = "Error preparando inserción: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
        }
    }
}

// Recuperar valores enviados previamente
$v_matricula  = htmlspecialchars($_POST['matricula'] ?? '', ENT_QUOTES, 'UTF-8');
$v_marca      = htmlspecialchars($_POST['marca'] ?? '', ENT_QUOTES, 'UTF-8');
$v_modelo     = htmlspecialchars($_POST['modelo'] ?? '', ENT_QUOTES, 'UTF-8');
$v_anio       = htmlspecialchars($_POST['ano'] ?? '', ENT_QUOTES, 'UTF-8');
$v_kilometros = htmlspecialchars($_POST['kms'] ?? '', ENT_QUOTES, 'UTF-8');

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

<form method="POST" action="">
    <label>Matrícula:<br>
        <input type="text" name="matricula" required value="<?= $v_matricula ?>">
        <?php if (isset($errors['matricula'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['matricula']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Marca:<br>
        <input type="text" name="marca" required value="<?= $v_marca ?>">
        <?php if (isset($errors['marca'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['marca']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Modelo:<br>
        <input type="text" name="modelo" required value="<?= $v_modelo ?>">
        <?php if (isset($errors['modelo'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['modelo']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Año:<br>
        <input type="text" name="ano" required value="<?= $v_anio ?>">
        <?php if (isset($errors['ano'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['ano']); ?></span>
        <?php endif; ?>
    </label><br>

    <label>Kilómetros:<br>
        <input type="text" name="kms" required value="<?= $v_kilometros ?>">
        <?php if (isset($errors['kms'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['kms']); ?></span>
        <?php endif; ?>
    </label><br><br>

    <button type="submit">Guardar vehículo</button>
    <button type="button" onclick="window.location.href='items.php'">Cancelar</button>
</form>

<script src="js/comprobacionVehiculo.js"></script>
</body>
</html>

