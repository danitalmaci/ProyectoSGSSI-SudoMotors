<?php
// ------------------------------------------------------------
// Formulario para borrar un vehículo (con confirmación)
// ------------------------------------------------------------

include 'connection.php'; 

// Comprobar que se ha pasado la matrícula correctamente
if (isset($_GET['matricula'])) {
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
} else {
    echo "No se ha especificado una matrícula.";
    exit;
}

// Cerrar conexión al final del script
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar vehículo</title>
</head>
<body>
    <h2>¿Seguro que deseas borrar este vehículo?</h2>
    <p><strong>Matrícula:</strong> <?= htmlspecialchars($vehiculo_data['MATRICULA']) ?></p>
    <p><strong>Marca:</strong> <?= htmlspecialchars($vehiculo_data['MARCA']) ?></p>
    <p><strong>Modelo:</strong> <?= htmlspecialchars($vehiculo_data['MODELO']) ?></p>

    <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este vehículo? Esta acción no se puede deshacer.');">
        <button type="submit">Sí, borrar vehículo</button>
        <button type="button" onclick="window.location.href='items.php'">Cancelar</button>
    </form>
</body>
</html>
