<?php
session_start();
// ------------------------------------------------------------
// Ver Perfil
// ------------------------------------------------------------

include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Cargar datos del usuario
$sql = "SELECT * FROM USUARIO WHERE USERNAME = '$username'";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $userRow = $result->fetch_assoc();
    $fullname = $userRow['NOMBRE'] . ' ' . $userRow['APELLIDOS'];
} else {
    die("Usuario no encontrado.");
}

$successMessage = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Tus datos se han actualizado correctamente";
}

$conn->close();

// Título y head
$pageTitle = "Perfil de " . htmlspecialchars($fullname) . " - SudoMotors";
include("includes/head.php");
?>

<nav style="display:flex; justify-content:flex-end; gap:1rem; margin-bottom:1rem;">
  <a href="items.php">Mostrar vehículos</a>
  <a href="index.php">Inicio</a>
</nav>

<hgroup>
  <h1>Perfil de <?= htmlspecialchars($fullname) ?></h1>
  <h3>Información de tu cuenta</h3>
</hgroup>

<?php if($successMessage): ?>
  <article role="alert">
    <strong><?= htmlspecialchars($successMessage) ?></strong>
  </article>
<?php endif; ?>

<p><strong>Usuario:</strong> <?= htmlspecialchars($userRow['USERNAME']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($userRow['EMAIL']) ?></p>
<p><strong>Teléfono:</strong> <?= htmlspecialchars($userRow['TELEFONO']) ?></p>
<p><strong>DNI:</strong> <?= htmlspecialchars($userRow['DNI']) ?></p>

<div style="margin-top: 1.5rem; display:flex; flex-direction:column; gap:0.75rem;">
  <!-- Cambio mínimo: usar enlace como botón en lugar de formulario -->
  <a href="modify_user.php" role="button">Modificar datos</a>

  <button type="button" onclick="window.location.href='login.php?logout=1'">
    Cerrar sesión
  </button>
</div>

<?php include("includes/footer.php"); ?>
