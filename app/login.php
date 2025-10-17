<?php session_start();
// ------------------------------------------------------------
// Formulario para Iniciar Sesión
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php'; 

$message="";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["user"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM USUARIO WHERE USERNAME = '$user' AND CONTRASENA = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
    	$userData = $result->fetch_assoc(); // <-- corregido
        $_SESSION['username'] = $userData['USERNAME']; // <-- correcto
        header("Location: items.php");
        exit;
    } else {
        $message = "Usuario o contraseña incorrecto.";
    }
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
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
        <label for="username">Usuario:</label>
        <input type="text" id="user" name="user" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="login_submit">Iniciar sesión</button>
        &nbsp;
        <span>¿No estás registrado? <a href="register.php">Regístrate</a></span>
    </form>
    
</body>
</html>
