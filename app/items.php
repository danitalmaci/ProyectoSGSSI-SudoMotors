<?php

// ------------------------------------------------------------
// Listado de coches
// ------------------------------------------------------------


// Datos de conexión a la base de datos (contenedor "db")
include 'connection.php';

// Consulta: obtener todos los datos necesarios de los vehiculos
$sql = "SELECT MARCA, MODELO, MATRICULA FROM VEHICULO";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar listado de vehiculos con sus respectivos atributos
    echo '
        <h1>VEHICULOS</h1>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Matricula</th>
                </tr>
            </thead>
            <tbody>
    ';

    while ($row = $result->fetch_assoc()) {
        echo '
            <tr>
                <td>' . htmlspecialchars($row["MARCA"]) . '</td>
                <td>' . htmlspecialchars($row["MODELO"]) . '</td>
                <td>' . htmlspecialchars($row["MATRICULA"]) . '</td>
            </tr>
        ';
    }

    // Aquí cerramos correctamente la tabla antes de seguir
    echo '
            </tbody>
        </table>
    ';
} else {
    echo "No hay vehiculos para mostrar actualmente.";
}

// 🔹 Ahora imprimimos el botón y el formulario (ya fuera de la tabla)
echo '
    <button class="btn-add" onclick="mostrarFormulario()">Añadir vehículo</button>

    <form id="form_añadir_vehiculo" action="guardar_vehiculo.php" method="POST" style="margin-top:20px;">
        <h2>Nuevo vehículo</h2>
        
        <label>Matrícula:</label><br>
        <input type="text" name="Matricula" required><br><br>
        
        <label>Marca:</label><br>
        <input type="text" name="Marca" required><br><br>

        <label>Modelo:</label><br>
        <input type="text" name="Modelo" required><br><br>
        
        <label>Kilometros:</label><br>
        <input type="text" name="Kilometros" required><br><br>
        
        <label>Año:</label><br>
        <input type="text" name="Anio" required><br><br>

        <button type="submit" class="btn-save">Guardar cambios</button>
    </form>
';

$conn->close();
?>

