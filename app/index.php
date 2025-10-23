<?php
session_start(); // ✅ Start the session
$pageTitle = "Inicio - SudoMotors";
include("includes/head.php");
?>

<hgroup>
  <h1>Home</h1>
  <h3>Bienvenido a SudoMotors</h3>
</hgroup>

<!-- Contenedor vertical -->
<nav style="display: flex; flex-direction: column; gap: 1rem;">
  <?php if (isset($_SESSION['username'])): ?>
      <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>" role="button" class="contrast">Ver perfil</a>
      <a href="login.php?logout=1" role="button" class="contrast">Cerrar sesión</a>
  <?php else: ?>
      <a href="register.php" role="button" class="contrast">Registro de usuario</a>
      <a href="login.php" role="button" class="contrast">Iniciar sesión</a>
  <?php endif; ?>
  <a href="items.php" role="button">Ver elementos</a>
</nav>


<?php include("includes/footer.php"); ?>
