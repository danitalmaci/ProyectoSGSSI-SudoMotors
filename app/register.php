<?php
// register.php - usa echo para HTML, validación en JS (cliente) y comprobación mínima en servidor
// Pegar en app/register.php (suponiendo connection.php en la misma carpeta)

// --- Incluir conexión ---
include 'connection.php'; // debe definir $conn (mysqli)

// --- Mensaje para mostrar en la UI ---
$message = '';

// --- Procesamiento POST (mínimo) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos los valores tal cual vienen del formulario (JS hace validación UX)
    // Aquí hacemos comprobaciones mínimas en servidor: campos no vacíos y unicidad.
    $username     = trim($_POST['usuario'] ?? '');
    $password     = $_POST['contrasena'] ?? '';
    $nombre       = trim($_POST['nombre'] ?? '');
    $apellidos    = trim($_POST['apellidos'] ?? '');
    $dni          = strtoupper(trim($_POST['dni'] ?? ''));
    $email        = trim($_POST['email'] ?? '');
    $telefono     = trim($_POST['telefono'] ?? '');
    $f_nacimiento = trim($_POST['f_nacimiento'] ?? '');

    // Comprobamos unicidad (USERNAME / EMAIL / DNI / TELEFONO) con sentencia preparada
    $checkSql = "SELECT USERNAME, EMAIL, DNI, TELEFONO FROM USUARIO WHERE USERNAME=? OR EMAIL=? OR DNI=? OR TELEFONO=?";
    $stmt = $conn->prepare($checkSql);
    if ($stmt) {
        $stmt->bind_param('ssss', $username, $email, $dni, $telefono);
        $stmt->execute();
        $res = $stmt->get_result();
        $exists = $res->fetch_assoc();
        $stmt->close();

        if ($exists) {
            if (isset($exists['USERNAME']) && $exists['USERNAME'] === $username) $message = "El usuario ya existe.";
            elseif (isset($exists['EMAIL']) && $exists['EMAIL'] === $email) $message = "El email ya está en uso.";
            elseif (isset($exists['DNI']) && $exists['DNI'] === $dni) $message = "El DNI ya está registrado.";
            elseif (isset($exists['TELEFONO']) && (string)$exists['TELEFONO'] === $telefono) $message = "El teléfono ya está en uso.";
            else $message = "Existe un registro con datos coincidentes.";
        } else {
            $insertSql = "INSERT INTO USUARIO (DNI, NOMBRE, APELLIDOS, TELEFONO, EMAIL, F_NACIMIENTO, CONTRASENA, USERNAME)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($insertSql);
            if ($stmt2) {
                $stmt2->bind_param('ssssssss', $dni, $nombre, $apellidos, $telefono, $email, $f_nacimiento, $password, $username);
                if ($stmt2->execute()) {
                    $stmt2->close();
                    $conn->close();
                    header("Location: login.php");
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

// --- Preparar valores para re-fill si hubo error (escapados) ---
$v_usuario   = htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES, 'UTF-8');
$v_nombre    = htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
$v_apellidos = htmlspecialchars($_POST['apellidos'] ?? '', ENT_QUOTES, 'UTF-8');
$v_dni       = htmlspecialchars($_POST['dni'] ?? '', ENT_QUOTES, 'UTF-8');
$v_email     = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
$v_telefono  = htmlspecialchars($_POST['telefono'] ?? '', ENT_QUOTES, 'UTF-8');
$v_f_nac     = htmlspecialchars($_POST['f_nacimiento'] ?? '', ENT_QUOTES, 'UTF-8');

$message_html = '';
if (!empty($message)) {
    $message_html = '<p style="color:red;">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
}

// --- Imprimir HTML con echo (heredoc) ---
echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro - SudoMotors</title>
</head>
<body>
  <h1>Registro de usuario</h1>
  {$message_html}
  <form id="register_form" method="POST" action="">
    <label>Usuario:<br>
      <input type="text" name="usuario" required value="{$v_usuario}">
    </label><br>

    <label>Contraseña:<br>
      <input type="password" name="contrasena" required>
    </label><br>

    <label>Nombre:<br>
      <input type="text" name="nombre" required value="{$v_nombre}">
    </label><br>

    <label>Apellidos:<br>
      <input type="text" name="apellidos" required value="{$v_apellidos}">
    </label><br>

    <label>DNI:<br>
      <input type="text" name="dni" required placeholder="11111111-Z" value="{$v_dni}">
    </label><br>

    <label>Email:<br>
      <input type="email" name="email" required value="{$v_email}">
    </label><br>

    <label>Teléfono:<br>
      <input type="text" name="telefono" required placeholder="9 dígitos" value="{$v_telefono}">
    </label><br>

    <label>Fecha de nacimiento:<br>
      <input type="date" name="f_nacimiento" required value="{$v_f_nac}">
    </label><br><br>

    <button type="button" id="register_submit">Registrarme</button>
  </form>

  <script src="js/comprobacionDatos.js"></script>
</body>
</html>
HTML;
?>
