<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./php/main.php"; // Ajusta la ruta según la estructura de tu proyecto

// Obtener el producto_id de la URL
$producto_id = isset($_GET['producto_id']) ? limpiar_cadena($_GET['producto_id']) : 0;

// Consultar el nombre del producto
$conexion = conexion();
$query = $conexion->prepare("SELECT producto_nombre FROM producto WHERE producto_id = :producto_id");
$query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $producto_nombre = $resultado['producto_nombre'];
} else {
    $producto_nombre = "Producto no encontrado";
}

// Verificar si se ha enviado el formulario
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar y validar los datos recibidos
    $fecha = limpiar_cadena($_POST['fecha']);
    $tipo_mantenimiento = limpiar_cadena($_POST['tipo_mantenimiento']);
    $descripcion = limpiar_cadena($_POST['descripcion']);
    $persona = limpiar_cadena($_POST['persona']);
    $firma = limpiar_cadena($_POST['firma']);
    $costo = $_POST['costo'];
    $producto_id = $_POST['producto_id'];

    // Validar los datos antes de insertar
    if (empty($fecha) || empty($tipo_mantenimiento) || empty($costo) || empty($producto_id)) {
        // Manejo de error si faltan campos obligatorios
        $mensaje = '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Todos los campos son obligatorios.
            </div>
        ';
    } else {
        // Guardando datos en la tabla mantenimientos
        $guardar_MANTENIMIENTO = conexion();
        $guardar_MANTENIMIENTO = $guardar_MANTENIMIENTO->prepare("INSERT INTO mantenimientos (fecha, tipo_mantenimiento, descripcion, persona, firma, costo, producto_id) VALUES(:fecha, :tipo_mantenimiento, :descripcion, :persona, :firma, :costo, :producto_id)");

        $marcadores = [
            ":fecha" => $fecha,
            ":tipo_mantenimiento" => $tipo_mantenimiento,
            ":descripcion" => $descripcion,
            ":persona" => $persona,
            ":firma" => $firma,
            ":costo" => $costo,
            ":producto_id" => $producto_id
        ];

        $guardar_MANTENIMIENTO->execute($marcadores);

        if ($guardar_MANTENIMIENTO->rowCount()==1){
            $mensaje = '
                <div class="notification is-info is-light">
                    <strong>¡MANTENIMIENTO REGISTRADO!</strong><br>
                    El mantenimiento se registró con éxito.
                </div>
            ';
            error_log("Mantenimiento registrado con éxito");
        } else {
            $mensaje = '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No se pudo registrar el mantenimiento, por favor intente nuevamente.
                </div>
            ';
            error_log("No se pudo registrar el Mantenimiento ");
        }

        $guardar_MANTENIMIENTO = null;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Mantenimientos</title>
    <!-- Incluir CSS u otros recursos si es necesario -->
</head>
<body>
<div class="container is-fluid mb-6">
    <h1 class="title">Mantenimientos</h1>
    <h2 class="subtitle">Nuevo mantenimiento</h2>
</div>

<div class="container pb-6 pt-6">
    <center><h2><?php echo htmlspecialchars($producto_nombre); ?></h2></center><br><br>

    <!-- Mostrar mensaje de confirmación o error -->
    <?php echo $mensaje; ?>

    <!-- Formulario para ingresar los datos de mantenimiento -->
    <form action="" method="POST"  class="FormularioAjax" autocomplete="off"  enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Fecha Mantenimiento</label>
                    <input class="input" type="date" name="fecha">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="tipo_mantenimiento">Tipo de Mantenimiento</label><br>
                    <div class="select is-rounded">
                        <select name="tipo_mantenimiento" id="tipo_mantenimiento">
                            <option value="" selected="">Seleccione una opción</option>
                            <option value="Correctivo">Correctivo</option>
                            <option value="Preventivo">Preventivo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripción:</label>
                    <input class="textarea" type="textarea" id="descripcion" name="descripcion"
                           pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="1000">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Persona o Empresa:</label>
                    <input class="input" type="text" id="persona" name="persona">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Firma:</label>
                    <input class="input" type="text" id="firma" name="firma" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Costo:</label>
                    <input class="input" type="text" id="costo" name="costo" step="0.01" required>
                </div>

                <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto_id); ?>">
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
        <br>
    </form>
</div>
</body>
<script href="js\ajax.js"></script>
</html>

