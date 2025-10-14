<?php
// ------------------------------------------------------------
// Página principal del sistema SudoMotors
// ------------------------------------------------------------

// Datos de conexión a la base de datos (contenedor "db")
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

// Conexión con la base de datos
$conn = mysqli_connect($hostname, $username, $password, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Consulta: obtener todos los usuarios registrados
$query = mysqli_query($conn, "SELECT * FROM USUARIOS") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SudoMotors</title>
</head>
<body>
    <h1>HOME</h1>
    <h2>Bienvenido a SudoMotors</h2>
    <p>Conexión a la base de datos establecida correctamente</p>

    <p>
        <a href="register.html">Ir al registro de usuario</a><br>
        <a href="login.html">Iniciar sesión</a><br>
        <a href="items.php">Ver elementos</a>
    </p>

    <h3>Usuarios registrados:</h3>

    <table border="1" cellpadding="5" cellspacing="0" bgcolor="#ffffff">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>

        <?php
        // Mostrar los datos de la tabla de usuarios
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nombre'] . "</td></tr>";
        }
        ?>
    </table>

    <br>
    <p>Ingeniería Informática de Gestión y Sistemas de Información: SGSSI. Proyecto: SISTEMA WEB</p>
</body>
</html>

<?php
// Cerrar la conexión con la base de datos
mysqli_close($conn);
?>
