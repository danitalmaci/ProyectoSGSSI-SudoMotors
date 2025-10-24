<?php session_start();
// ------------------------------------------------------------
// Formulario para modificar Vehiculo
// ------------------------------------------------------------

// Datos de conexión a la base de datos
include 'connection.php';

// Comprobar si la URL contiene el parámetro necesario, la matrícula
if (!isset($_GET['matricula'])) {
    // Si no, redirije a items.php
    header("Location: items.php");
    exit;
}

// Inicializar variables, además de guardar el parámetro matrícula del URL
$matricula = $_GET['matricula'];
$errors = [];

// Buscar los datos del vehículo a partir del parámetro del formulario
$query = mysqli_query($conn, "SELECT * FROM VEHICULO WHERE MATRICULA='$matricula'");
// Si no hay resultados, se guarda null
if (!$query || mysqli_num_rows($query) == 0) {
    $vehiculo_data = null;
} 
// Si hay resultados, se guardan los datos actuales del vehículo
else {
    $vehiculo_data = mysqli_fetch_assoc($query);
}

// Actualizar los datos del vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos nuevos del vehículo a partir del formulario
    $new_matricula = $_POST['matricula'] ?? '';
    $new_marca     = $_POST['marca'] ?? '';
    $new_modelo    = $_POST['modelo'] ?? '';
    $new_ano       = $_POST['ano'] ?? '';
    $new_kms       = $_POST['kms'] ?? '';

    // Comprobar si ya existe otro coche con la misma matrícula
    $check_vehiculo = mysqli_query(
        $conn,
        "SELECT * FROM VEHICULO WHERE MATRICULA='$new_matricula' AND MATRICULA <> '$matricula'"
    );
    
    // Si ya existe un coche con la matrícula, se almacena el error
    if ($check_vehiculo && mysqli_num_rows($check_vehiculo) > 0) {
        $errors['matricula'] = "La matrícula ya existe.";
    }

    // Si no hay errores se sigue con la modificacion de datos
    if (empty($errors)) {
        $sql = "UPDATE VEHICULO SET 
                MATRICULA='$new_matricula',
                MARCA='$new_marca',
                MODELO='$new_modelo',
                ANO='$new_ano',
                KMS='$new_kms'
                WHERE MATRICULA='$matricula'";
        
        // Se ejecuta la operación y se almacena el resultado de la misma
        $result = mysqli_query($conn, $sql);

        // Si la operación ha sido correcta, redirije a la página show_item con el flag success, que indica el éxito de la ejecución
        if ($result) {
            header("Location: show_item.php?matricula=" . urlencode($new_matricula) . "&success=1");
            exit;
        } 

        // Si la operación no se ha ejecutado correctamente, se almacena el error
        else {
            
            $errors['general'] = "Error al actualizar el vehículo: " . mysqli_error($conn);
        }
    } 

    // En caso de errores, se evita el borrado de datos introducidos en el formulario
    else {
        $vehiculo_data = [
            'MATRICULA' => $new_matricula,
            'MARCA'     => $new_marca,
            'MODELO'    => $new_modelo,
            'ANO'       => $new_ano,
            'KMS'       => $new_kms,
        ];
    }
}

// Se cierra la conexión con la base de datos
$conn->close();

// Título de la página
$pageTitle = "Modificar vehículo - SudoMotors";
include("includes/head.php");
?>

// HTML
// Botones para navegar por la web
<nav style="display:flex; justify-content:flex-end; gap:1rem; margin-bottom:1rem;">
    <a href="items.php">Mostrar vehículos</a>
    // Si no está la sesión iniciada, no se puede ver el perfil
    <?php if (!empty($_SESSION['username'])): ?>
        <a href="show_user.php?user=<?= urlencode($_SESSION['username']) ?>">Ver perfil</a>
    <?php endif; ?>
</nav>

// Subtítulo y explicación
<hgroup>
    <h1>Modificar datos del vehículo</h1>
    <h3>Actualiza la información y guarda los cambios</h3>
</hgroup>

// En caso de algún error, lo notifica
<?php if (!empty($errors['general'])): ?>
    <article role="alert"><strong><?= htmlspecialchars($errors['general']) ?></strong></article>
<?php endif; ?>

// En caso de no encontrar el vehículo a modificar, lo notifica
<?php if ($notFound): ?>
    <article role="alert"><strong>Vehículo no encontrado.</strong></article>
    <button type="button" onclick="window.location.href='items.php'">Volver</button>
    <?php include("includes/footer.php"); exit; ?>
<?php endif; ?>

// Formulario para la modificación de parámetros
<form id="item_modify_form" method="post" action="">
    <label>Matrícula
        <input
            type="text"
            name="matricula"
            required
            placeholder="1111 ZZZ"
            value="<?= htmlspecialchars($vehiculo_data['MATRICULA']) ?>"
        >
        <?php if (isset($errors['matricula'])): ?>
            <span style="color:red; display:block; font-size:0.9em;"><?= htmlspecialchars($errors['matricula']) ?></span>
        <?php endif; ?>
    </label>

    <label>Marca
        <input type="text" name="marca" required value="<?= htmlspecialchars($vehiculo_data['MARCA']) ?>">
    </label>

    <label>Modelo
        <input type="text" name="modelo" required value="<?= htmlspecialchars($vehiculo_data['MODELO']) ?>">
    </label>

    <label>Año
        <input type="text" name="ano" required value="<?= htmlspecialchars($vehiculo_data['ANO']) ?>">
    </label>

    <label>Kilómetros
        <input type="text" name="kms" required value="<?= htmlspecialchars($vehiculo_data['KMS']) ?>">
    </label>

    <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:0.75rem;">
        <button type="button" id="item_modify_submit">Guardar cambios</button>
        <button type="button" onclick="window.location.href='show_item.php?matricula=<?= urlencode($vehiculo_data['MATRICULA']) ?>'">
            Cancelar
        </button>
    </div>
</form>

// Ejecutar el js para la validación de datos
<script src="js/comprobacionVehiculo.js"></script>

<?php include("includes/footer.php"); ?>
