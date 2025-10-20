<?php
session_start();

// Conexión a la base de datos
include 'connection.php';

// Consulta para obtener los vehículos
$sql = "SELECT MARCA, MODELO, MATRICULA FROM VEHICULO";
$result = $conn->query($sql);

// Guardar resultados en una variable para mostrarlos luego en el body
$vehiculos_html = "";

if ($result->num_rows > 0) {
    $vehiculos_html .= '
        <h1>VEHÍCULOS DISPONIBLES</h1>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Matrícula</th>
                </tr>
            </thead>
            <tbody>
    ';

    while ($row = $result->fetch_assoc()) {
        $vehiculos_html .= '
            <tr>
                <td>' . htmlspecialchars($row["MARCA"]) . '</td>
                <td>' . htmlspecialchars($row["MODELO"]) . '</td>
                <td>
                    <a href="show_item.php?matricula=' . urlencode($row["MATRICULA"]) . '">
                        ' . htmlspecialchars($row["MATRICULA"]) . '
                    </a>
                </td>
            </tr>
        ';
    }

    $vehiculos_html .= '
            </tbody>
        </table>
    ';
} else {
    $vehiculos_html .= "<h3>No hay vehículos para mostrar actualmente.</h3>";
}

$successMessage = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "El vehículo se ha añadido correctamente";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Vehículos</title>
</head>
<body>
<?php if($successMessage): ?>
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<div style="position: absolute; top: 20px; right: 20px;">
	<a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil </a><br>
</div>

<?php echo $vehiculos_html; ?>

<br>
<form action="add_item.php" method="GET">
    <button type="submit">Añadir vehículo</button>
</form>

</body>
</html>
