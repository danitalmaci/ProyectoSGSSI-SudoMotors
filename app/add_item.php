<?php
// ------------------------------------------------------------
// Formulario para añadir Vehículo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Variable para mensajes de error o éxito
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$matricula  = $_POST['matricula'] ?? '';
    $marca		= $_POST['marca'] ?? '';
    $modelo     = $_POST['modelo'] ?? '';
    $kilometros    	= $_POST['kms'] ?? '';
    $anio       = $_POST['ano'] ?? '';

    // Comprobación mínima: unicidad
    $checkSql = "SELECT MATRICULA FROM VEHICULO WHERE MATRICULA=?";
    $stmt = $conn->prepare($checkSql); //Devuelve false si hay fallo en la consulta
    if ($stmt) {
        $stmt->bind_param('s', $matricula); //Con 's' se indica que el parametro va a ser String.
        $stmt->execute(); //Lanza la consulta
        $res = $stmt->get_result(); //Obtiene el resultado
        $exists = $res->fetch_assoc(); //Toma la primera fila como array asociativo, null si no hay filas.
        $stmt->close();

        if ($exists) { //Si no es null, es decir, si existe alguna fila en la que coincide algún elemento.
          $errors = []; 
          if ($exists['MATRICULA'] === $matricula) $errors['matricula'] = "El usuario ya existe.";
        } else { //Si no coincide ninguna, insertamos a la tabla.
            $insertSql = "INSERT INTO VEHICULO (MATRICULA, MARCA, MODELO, ANO, KMS) VALUES (?,?,?,?,?)";
            $stmt2 = $conn->prepare($insertSql);
            if ($stmt2) {
                $stmt2->bind_param('sssii', $matricula, $marca, $modelo, $anio, $kilometros );
                if ($stmt2->execute()) { //Si la ejecución funciona
                    $stmt2->close();
                    $conn->close(); 
                    header("Location: items.php");
                    exit;
                } else {
                    $message = "Error al insertar el vehiculo: " . htmlspecialchars($stmt2->error, ENT_QUOTES, 'UTF-8');
                    $stmt2->close();
                }
            } else {
                $message = "Error preparando inserción: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
            }
        }
    } else {
        $message = "Error preparando comprobación: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
    }
}

//Recuperamos los valores enviados por el formulario
$v_matricula   = htmlspecialchars($_POST['matricula'] ?? '', ENT_QUOTES, 'UTF-8');
$v_marca    = htmlspecialchars($_POST['marca'] ?? '', ENT_QUOTES, 'UTF-8');
$v_modelo = htmlspecialchars($_POST['modelo'] ?? '', ENT_QUOTES, 'UTF-8');
$v_kilometros       = htmlspecialchars($_POST['kilometros'] ?? '', ENT_QUOTES, 'UTF-8');
$v_anio     = htmlspecialchars($_POST['ano'] ?? '', ENT_QUOTES, 'UTF-8');


// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir vehículo</title>
</head>
<body>
<div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px;">
	<a href="items.php">Inicio </a><br>
	<a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil </a><br>
</div>
  <h1>Añadir nuevo vehículo</h1>

  <?php if (!empty($message)): ?>
    <p style="color:red;"><?php echo $message; ?></p>
  <?php endif; ?>

  <form action="" method="POST">

      <label>Matrícula:<br>
      <input type="text" name="matricula" required value="<?php echo $v_matricula; ?>">
      <?php if (isset($errors['matricula'])): ?>
      <span style="color:red;"><?php echo htmlspecialchars($errors['matricula']); ?></span>
      <?php endif; ?>
   	  </label><br>

 	  <label>Marca:<br>
      <input type="text" name="marca" required value="<?php echo $v_marca; ?>">
      </label><br>

      <label>Modelo:<br>
      <input type="text" name="modelo" required value="<?php echo $v_modelo; ?>">
   	  </label><br>

      <label>Kilómetros:<br>
      <input type="text" name="kms" required min="0" value="<?php echo $v_kilometros; ?>">
      <?php if (isset($errors['kms'])): ?>
      <span style="color:red;"><?php echo htmlspecialchars($errors['kms']); ?></span>
      <?php endif; ?>
      </label><br>
    
      <label>Año:<br>
      <input type="text" name="ano" required min="1800" value="<?php echo $v_ano; ?>">
      <?php if (isset($errors['ano'])): ?>
	  <span style="color:red;"><?php echo htmlspecialchars($errors['ano']); ?></span>
      <?php endif; ?>
      </label><br>
      
	<br>
      <button type="submit">Guardar vehículo</button>
  </form>

  <br>
  <a href="items.php"> Volver al listado de vehiculos</a>
  
  <script src="js/comprobacionVehiculo.js"></script>
  
</body>
</html>


