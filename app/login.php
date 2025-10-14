<?php
require "connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Usuario o contraseña incorrecto.";
    }
}
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
