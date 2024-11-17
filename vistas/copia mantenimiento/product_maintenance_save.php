<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../php/main.php"; // Ajusta la ruta según la estructura de tu proyecto

// Verificar si se ha enviado el formulario
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
        echo "Todos los campos son obligatorios.";
    } else {
        // Guardando datos en la tabla mantenimientos
        $guardar_producto = conexion();
        $guardar_producto = $guardar_producto->prepare("INSERT INTO mantenimientos (fecha, tipo_mantenimiento, descripcion, persona, firma, costo, producto_id) VALUES(:fecha, :tipo_mantenimiento, :descripcion, :persona, :firma, :costo, :producto_id)");

        $marcadores = [
            ":fecha" => $fecha,
            ":tipo_mantenimiento" => $tipo_mantenimiento,
            ":descripcion" => $descripcion,
            ":persona" => $persona,
            ":firma" => $firma,
            ":costo" => $costo,
            ":producto_id" => $producto_id
        ];

        $guardar_producto->execute($marcadores);

        if ($guardar_producto->rowCount() == 1) {
            echo '
                <div class="notification is-info is-light">
                    <strong>¡MANTENIMIENTO REGISTRADO!</strong><br>
                    El mantenimiento se registró con éxito.
                </div>
            ';
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No se pudo registrar el mantenimiento, por favor intente nuevamente.
                </div>
            ';
        }

        $guardar_producto = null;
    }
} else {
    // Redirigir al formulario si no se ha enviado el formulario
    header("Location: product_maintenance.php?producto_id=" . htmlspecialchars($_POST['producto_id']));
    exit();
}
?>
