<?php

// ------------------------------------------------------------
// Litado de coches
// ------------------------------------------------------------


// Datos de conexión a la base de datos (contenedor "db")
include 'connection.php';

// Consulta: obtener todos los datos necesarios de los vehiculos
$sql = "SELECT MARCA,MODELO,MATRICULA FROM VEHICULO";
$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Mostrar listado de vehiculos con sus respectivos atributos
		echo '
			<h1>VEHICULOS</h1>
			<table>
				<thead>
					<tr>
				        <th>Marca</th>
				        <th>Modelo</th>
				        <th>Matricula</th>
					</tr>
				</thead>
		';
		while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td><input type="text" name="" value="' . $row["MARCA"] . '"></td>
                <td><input type="text" name="" value="' . $row["MODELO"] . '"></td>
                <td><input type="text" name="" value="' . $row["MATRICULA"] . '"></td>
              </tr>';
              echo "<tr><td>" . $row['USUARIO'] . "</td><td>" . $row['NOMBRE'] . "</td></tr>";
    	}
	} else {
            echo "Error: No fue posible acceder a la información de los vehiculos.";
    }


$conn->close();
?>

