<?php
// ------------------------------------------------------------
// Formulario para borrar un vehículo (con confirmación)
// ------------------------------------------------------------

include 'connection.php'; 
session_start();

if (!isset($_GET['matricula'])) {
    echo "No se ha especificado una matrícula.";
    exit;
}

$matricula = $_GET['matricula'];

// Buscar los datos del vehículo
$query = mysqli_query($conn, "SELECT * FROM VEHICULO WHERE MATRICULA='$matricula'");

if (!$query || mysqli_num_rows($query) <= 0) {
    echo "Vehículo no encontrado.";
    exit;
}

$vehiculo_data = mysqli_fetch_assoc($query);

// Si se ha confirmado la eliminación (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    mysqli_query($conn, "DELETE FROM VEHICULO WHERE MATRICULA='$matricula'");
    echo "
    <script>
        alert('El vehículo se ha borrado con éxito.');
        window.location.href = 'items.php';
    </script>
    ";
    exit;
}

$conn->close();

// Título y head
$pageTitle = "Borrar vehículo - SudoMotors";
include("includes/head.php");
?>

<nav style="display:flex; justify-content:flex-end; gap:1rem; margin-bottom:1rem;">
  <a href="items.php">Mostrar vehículos</a>
  <?php if (!empty($_SESSION['username'])): ?>
    <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil</a>
  <?php endif; ?>
</nav>

<hgroup>
  <h1>Eliminar vehículo</h1>
  <h3>¿Seguro que deseas borrar este vehículo?</h3>
</hgroup>

<table>
  <tr><th>Matrícula</th><td><?= htmlspecialchars($vehiculo_data['MATRICULA']) ?></td></tr>
  <tr><th>Marca</th><td><?= htmlspecialchars($vehiculo_data['MARCA']) ?></td></tr>
  <tr><th>Modelo</th><td><?= htmlspecialchars($vehiculo_data['MODELO']) ?></td></tr>
</table>

<form method="post" 
      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este vehículo? Esta acción no se puede deshacer.');"
      style="margin-top:1.5rem; display:flex; flex-direction:column; gap:0.5rem;">
  
  <button type="submit" class="contrast">Sí, borrar vehículo</button>
  <button type="button" onclick="window.location.href='items.php'">Cancelar</button>
</form>

<?php include("includes/footer.php"); ?>
