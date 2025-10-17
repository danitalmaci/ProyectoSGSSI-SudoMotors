<?php
// ------------------------------------------------------------
// Listado de Vehiculos
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Consulta: obtener todos los datos necesarios de los vehiculos
$sql = "SELECT MARCA, MODELO, MATRICULA FROM VEHICULO";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar listado de vehiculos con sus respectivos atributos
    echo '
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
        echo '
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

    echo '
            </tbody>
        </table>
    ';
} else {
    echo "<h3>No hay vehículos para mostrar actualmente.</h3>";
}

// Cerrar conexión
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Vehículos</title> 
</head>
<body>
	<div style="position: absolute; top: 20px; right: 20px;">
            <form action="show_user.php" method="get">
                <button type="submit">Ver perfil</button>
            </form>
    </div>
	<br>
    <form action="add_item.php" method="get"> 
        <button type="submit">Añadir vehículo</button>
    </form>
</body>
</html>


