<?php

// ------------------------------------------------------------
// Formulario para registrarse
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php'; 

//Variable para almacenar errores o mensajes para mostrar en la página.
$message = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Entra solo si el formulario se ha enviado por POST
    $username     = $_POST['usuario'] ?? '';
    $password     = $_POST['contrasena'] ?? '';
    $confirm_password = $_POST['confirmar_contrasena'] ?? '';
    $nombre       = $_POST['nombre'] ?? '';
    $apellidos    = $_POST['apellidos'] ?? '';
    $dni          = $_POST['dni'] ?? '';
    $email        = $_POST['email'] ?? '';
    $telefono     = $_POST['telefono'] ?? '';
    $f_nacimiento = $_POST['f_nacimiento'] ?? '';

    // Comprobación mínima: unicidad
    $checkSql = "SELECT USERNAME, EMAIL, DNI FROM USUARIO WHERE USERNAME=? OR EMAIL=? OR DNI=?";
    $stmt = $conn->prepare($checkSql); //Devuelve false si hay fallo en la consulta
    if ($stmt) {
        $stmt->bind_param('sss', $username, $email, $dni); //Con 'sss' se indica que los 4 parámetros van a ser Strings.
        $stmt->execute(); //Lanza la consulta
        $res = $stmt->get_result(); //Obtiene el resultado
        $exists = $res->fetch_assoc(); //Toma la primera fila como array asociativo, null si no hay filas.
        $stmt->close();

        $errors = [];

        if ($password !== $confirm_password) {
          $errors['confirmar_contrasena'] = "Las contraseñas no coinciden.";
        }

        if ($exists) { //Si no es null, es decir, si existe alguna fila en la que coincide algún elemento.
          if ($exists['USERNAME'] === $username) $errors['usuario'] = "El usuario ya existe.";
          if ($exists['DNI'] === $dni) $errors['dni'] = "El DNI ya está registrado.";
          if ($exists['EMAIL'] === $email) $errors['email'] = "El email ya está en uso.";
        } 

        if (empty($errors)) { //Si no hay errores.
            $insertSql = "INSERT INTO USUARIO (DNI, NOMBRE, APELLIDOS, TELEFONO, EMAIL, F_NACIMIENTO, CONTRASENA, USERNAME)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($insertSql);
            if ($stmt2) {
                $stmt2->bind_param('ssssssss', $dni, $nombre, $apellidos, $telefono, $email, $f_nacimiento, $password, $username);
                if ($stmt2->execute()) { //Si la ejecución funciona
                    $stmt2->close();
                    $conn->close(); 
                    session_start(); // Se inicia la sesión
        	    $_SESSION['username'] = $username; // Guardamos usuario en sesión
                    header("Location: items.php");
                    exit;
                } else {
                    $message = "Error al insertar usuario: " . htmlspecialchars($stmt2->error, ENT_QUOTES, 'UTF-8');
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
$v_usuario   = htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES, 'UTF-8');
$v_nombre    = htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
$v_apellidos = htmlspecialchars($_POST['apellidos'] ?? '', ENT_QUOTES, 'UTF-8');
$v_dni       = htmlspecialchars($_POST['dni'] ?? '', ENT_QUOTES, 'UTF-8');
$v_email     = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
$v_telefono  = htmlspecialchars($_POST['telefono'] ?? '', ENT_QUOTES, 'UTF-8');
$v_f_nac     = htmlspecialchars($_POST['f_nacimiento'] ?? '', ENT_QUOTES, 'UTF-8');

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro - SudoMotors</title> 
</head>
<body>
  <h1>Registro de usuario</h1>

  <?php if (!empty($message)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>

  <form id="register_form" method="POST" action="">
    <label>Usuario:<br>
      <input type="text" name="usuario" required value="<?php echo $v_usuario; ?>">
      <?php if (isset($errors['usuario'])): ?>
        <span style="color:red;"><?php echo htmlspecialchars($errors['usuario']); ?></span>
      <?php endif; ?>
    </label><br>

    <label>Contraseña:</label>
    <div style="display:flex; align-items:center; gap:10px;">
  	<input type="password" name="contrasena" id="contrasena" required>
  	<input type="checkbox" id="togglePass"> Mostrar contraseña
    </div>
    <?php if (isset($errors['contrasena'])): ?>
  	<div style="color:red; font-size:0.9em;"><?= htmlspecialchars($errors['contrasena']) ?></div>
    <?php endif; ?>
    <br>

    <label>Confirmar contraseña:<br>
      <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
      <?php if (isset($errors['confirmar_contrasena'])): ?>
        <span style="color:red;"><?php echo htmlspecialchars($errors['confirmar_contrasena']); ?></span>
      <?php endif; ?>
    </label><br>


    <label>Nombre:<br>
      <input type="text" name="nombre" required value="<?php echo $v_nombre; ?>">
    </label><br>

    <label>Apellidos:<br>
      <input type="text" name="apellidos" required value="<?php echo $v_apellidos; ?>">
    </label><br>

    <label>DNI:<br>
      <input type="text" name="dni" required placeholder="11111111-Z" value="<?php echo $v_dni; ?>">
      <?php if (isset($errors['dni'])): ?>
        <span style="color:red;"><?php echo htmlspecialchars($errors['dni']); ?></span>
      <?php endif; ?>
    </label><br>

    <label>Email:<br>
      <input type="email" name="email" required value="<?php echo $v_email; ?>">
      <?php if (isset($errors['email'])): ?>
        <span style="color:red;"><?php echo htmlspecialchars($errors['email']); ?></span>
      <?php endif; ?>
    </label><br>

    <label>Teléfono:<br>
      <input type="text" name="telefono" required placeholder="9 dígitos" value="<?php echo $v_telefono; ?>">
      <?php if (isset($errors['telefono'])): ?>
        <span style="color:red;"><?php echo htmlspecialchars($errors['telefono']); ?></span>
      <?php endif; ?>
    </label><br>

    <label>Fecha de nacimiento:<br>
      <input type="date" name="f_nacimiento" required value="<?php echo $v_f_nac; ?>">
    </label><br><br>

    <button type="button" id="register_submit">Registrarme</button>
    <button type="button" onclick="window.location.href='login.php'">
    		Cancelar
    </button>
  </form>

  <script src="js/comprobacionDatos.js"></script>
  
  <script>
    const pass1 = document.getElementById('contrasena');
    const pass2 = document.getElementById('confirmar_contrasena');
    const toggle1 = document.getElementById('togglePass');

    toggle1.addEventListener('change', () => {
      pass1.type = toggle1.checked ? 'text' : 'password';
      pass2.type = toggle1.checked ? 'text' : 'password';
    });
  </script>
</body>
</html>
