<?php 
  $pageTitle = "Inicio - SudoMotors";
  include("includes/head.php");
?>

<hgroup>
  <h1>Home</h1>
  <h3>Bienvenido a SudoMotors</h3>
</hgroup>

<!-- Contenedor vertical -->
<nav style="display: flex; flex-direction: column; gap: 1rem;">
  <a href="register.php" role="button" class="contrast">Registro de usuario</a>
  <a href="login.php" role="button" class="contrast">Iniciar sesión</a>
  <a href="items.php" role="button">Ver elementos</a>
</nav>

<?php include("includes/footer.php"); ?>
