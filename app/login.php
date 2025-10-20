<?php
session_start();
// ------------------------------------------------------------
// Formulario para Iniciar Sesión
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["user"];
    $password = $_POST["contrasena"];

    $sql = "SELECT * FROM USUARIO WHERE USERNAME = '$user' AND CONTRASENA = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        session_start(); // Se inicia la sesión
        $_SESSION['username'] = $userData['USERNAME']; // Guardamos usuario en sesión
        header("Location: items.php"); // Redirigimos a la lista de vehículos
        exit;
    } else {
        $message = "Usuario o contraseña incorrecto.";
    }
}

// Cerrar sesión si se llama con ?logout=1
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if (!empty($message)): ?>
        <p style="color:red;"><?= $message ?></p>
    <?php endif; ?>

    <form id="login_form" method="POST" action="">
        <label for="user">Usuario:</label>
        <input type="text" id="user" name="user" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <input type="checkbox" id="togglePass"> Mostrar contraseña
        <br><br>
	
	<div>
        <button type="submit">Iniciar sesión</button>
        &nbsp;
        <span>¿No estás registrado? <a href="register.php">Regístrate</a></span>
        <div>
        <div style="margin-top: 10px;">
        <button type="button" onclick="window.location.href='show_user.php?user=<?= urlencode($_SESSION['username']) ?>'">
    		Cancelar
	</button>
	<div>
    </form>
    <script>
      const pass1 = document.getElementById('contrasena');
      const toggle1 = document.getElementById('togglePass');

      toggle1.addEventListener('change', () => {
        pass1.type = toggle1.checked ? 'text' : 'password';
      });
    </script>
</body>
</html>
