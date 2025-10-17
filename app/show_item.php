<?php	
// ------------------------------------------------------------
// Ver información del vehiculo	
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

$item = $_SESSION['matricula'];

$sql = "SELECT * FROM VEHICULO WHERE MATRICULA = '$item'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['matricula'] = $row['MATRICULA'];
    echo '
    <h1>Datos del vehículo seleccionado</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr><th>Marca</th><td>' . $row["MARCA"] . '</td></tr>
        <tr><th>Modelo</th><td>' . $row["MODELO"] . '</td></tr>
        <tr><th>Matrícula</th><td>' . $row["MATRICULA"] . '</td></tr>
        <tr><th>Año</th><td>' . $row["ANO"] . '</td></tr>
        <tr><th>Kilómetros</th><td>' . $row["KMS"] . '</td></tr>
    </table>

    <div style="margin-top:25px; display:flex; gap:15px;">
        <form action="/modify_item.php" method="get">
            <button type="submit"
                style="padding:10px 20px; background:#007BFF; color:white; border:none; border-radius:5px; cursor:pointer;"
                Modificar Datos
            </button>
        </form>

        <form action="/delete_item.php" method="get">
            <button type="submit"
                style="padding:10px 20px; background:#DC3545; color:white; border:none; border-radius:5px; cursor:pointer;"
                Eliminar Vehículo
            </button>
        </form>
    </div>';
} else {
    echo "No se encontró información del vehículo.";
}

// Cerrar conexión
$conn->close();
?>
