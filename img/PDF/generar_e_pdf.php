<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Verifica si el equipo_id está presente en la URL
if (!isset($_GET['equipo_id'])) {
    die('Falta el ID del equipo en la URL.');
}

$equipo_id = $_GET['equipo_id'];

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u239335834_danilodoria";
$password = "Danilo@2024";
$database = "u239335834_inventario";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener detalles del equipo
$sql_equipo = "SELECT serie, equipo, proveedor, ubicacion, f_inicio_garantia, f_final_garantia 
               FROM equipos_generales 
               WHERE id = $equipo_id";
$result_equipo = $conexion->query($sql_equipo);

if ($result_equipo->num_rows > 0) {
    $equipo = $result_equipo->fetch_assoc();

    // Datos del equipo
    $serie = $equipo['serie'];
    $equipo_nombre = $equipo['equipo'];
    $proveedor = $equipo['proveedor'];
    $ubicacion = $equipo['ubicacion'];
    $f_inicio_garantia = $equipo['f_inicio_garantia'];
    $f_final_garantia = $equipo['f_final_garantia'];
} else {
    die('No se encontró información del equipo.');
}

// Consulta SQL para obtener mantenimientos del equipo y ordenarlos por fecha
$sql = "SELECT fecha, tipo_mantenimiento, descripcion, persona, firma, costo 
        FROM mantenimientos 
        WHERE equipo_id = $equipo_id 
        ORDER BY fecha ASC";
$result = $conexion->query($sql);
$datos = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
} else {
    die('No se encontraron mantenimientos para este equipo.');
}

// Asignar consecutivo automáticamente
$consecutivo = 1;
foreach ($datos as &$dato) {
    $dato['consecutivo'] = str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
    $consecutivo++;
}

// Crear el contenido HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            float: right;
            width: 100px;
            height: auto;
        }
        .header .title {
            text-align: center;
        }
        .table1 {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }
        .table1 th, .table1 td {
            border: 1px solid #999;
            padding: 5px;
            text-align: center;
            font-size: 10px;
        }
        .table1 th {
            background-color: #ffffff;
        }
        .table2 {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table2 th, .table2 td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }
        .table2 th {
        }
    </style>
</head>
<body> 
    <table class="table1">
        <thead>
            <tr>
                <th>CODIGO: </th>
                <th>SGC-AAF09-A</th>
                <th>SISTEMA DE GESTION DE LA CALIDAD</th>
                <th rowspan="3"><img src="https://sanagustin.edu.co/wp-content/uploads/2023/01/san-agustin.png" alt="" style="width:100px; height:auto;"></th>
            </tr>
            <tr>
                <th>VERSION: </th>
                <th>3</th>
                <th rowspan="2">HOJA DE VIDA EQUIPOS</th>
            </tr>
            <tr>
                <th>PAGINA: </th>
                <th>1</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table1">
        <thead>
            <tr>
                <th>EQUIPO: </th>
                <th>' . htmlspecialchars($equipo_nombre) . '</th>
                <th>SERIE #:</th>
                <th>' . htmlspecialchars($serie) . '</th>
                <th>PROVEEDOR:</th>
                <th>' . htmlspecialchars($proveedor) . '</th>
            </tr>
            <tr>
                <th>UBICACION: </th>
                <th>' . htmlspecialchars($ubicacion) . '</th>
                <th>F. INICIO GARANTIA:</th>
                <th>' . htmlspecialchars($f_inicio_garantia) . '</th>
                <th>F. FINAL GARANTIA:</th>
                <th>' . htmlspecialchars($f_final_garantia) . '</th>
            </tr>
        </thead>
    </table>
    <table class="table2">
        <thead>
            <tr>
                <th>CONSECUTIVO</th>
                <th>FECHA</th>
                <th>TIPO</th>
                <th>DESCRIPCION DEL MANTENIMIENTO</th>
                <th>PERSONA O EMPRESA</th>
                <th>FIRMA</th>
                <th>COSTO</th>
            </tr>
        </thead>
        <tbody>';

foreach ($datos as $fila) {
    $html .= '<tr>
        <td>' . htmlspecialchars($fila['consecutivo']) . '</td>
        <td>' . htmlspecialchars($fila['fecha']) . '</td>
        <td>' . htmlspecialchars($fila['tipo_mantenimiento']) . '</td>
        <td>' . htmlspecialchars($fila['descripcion']) . '</td>
        <td>' . htmlspecialchars($fila['persona']) . '</td>
        <td>' . htmlspecialchars($fila['firma']) . '</td>
        <td>' .htmlspecialchars('$' . number_format($fila['costo'], 0, ',', '.')) . '</td>
    </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Configuración de Dompdf
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', true);  // Habilitar la carga remota de imágenes
$dompdf = new Dompdf($options);

// Cargar el contenido HTML
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño y la orientación del papel
$dompdf->setPaper('A4', 'landscape');

// Renderizar el HTML como PDF
$dompdf->render();

// Salida del PDF generado a la descarga
$dompdf->stream('HOJADEVIDA.pdf', array('Attachment' => false));
?>
