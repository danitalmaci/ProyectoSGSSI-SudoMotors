<?php
// ------------------------------------------------------------
// Formulario para borrar un vehículo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php'; 

// Buscar los datos del vehiculo
$query = mysqli_query($conn, "SELECT * FROM VEHICULO WHERE MATRICULA='" . $_SESSION['matricula'] . "'");

if (!$query || mysqli_num_rows($query) < 0) {
        echo "Vehiculo no encontrado.";
        exit;
}

$vehiculo_data = mysqli_fetch_assoc($query);

// Borrar vehiculo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    mysqli_query($conn, "DELETE FROM VEHICULO WHERE MATRICULA='" . $_SESSION['matricula'] . "'");
    unset($_SESSION['matricula']); // Limpia la matrícula de la sesión

    // Mostrar mensaje de éxito con JavaScript y redirigir
    echo "
    <script>
        alert(' El vehículo se ha borrado con éxito.');
        window.location.href = 'index.php';
    </script>
    ";
    exit;
}

// Cerrar conexión
$conn->close();
?>

 

