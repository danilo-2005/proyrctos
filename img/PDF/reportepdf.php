<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u239335834_danilodoria";
$password = "Danilo@2024";
$database = "u239335834_inventario"; // Reemplaza con el nombre de tu base de datos

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener todos los equipos generales
$sql = "SELECT * FROM equipos_generales";
$result = $conexion->query($sql);
$equipos = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $equipos[] = $row;
    }
} else {
    die('No se encontraron equipos.');
}

// Crear el contenido HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body> 
    <table>
        <caption>REPORTE DE EQUIPOS GENERALES</caption>
        <tr>
            
            <th>SERIE</th>
            <th>EQUIPO</th>
            <th>PROVEEDOR</th>
            <th>UBICACION</th>
            <th>INICIO GARANTIA</th>
            <th>FINAL GARANTIA</th>
            <th>COMENTARIOS</th>
        </tr>';

foreach ($equipos as $equipo) {
    $html .= '<tr>

        <td>' . htmlspecialchars($equipo['serie']) . '</td>
        <td>' . htmlspecialchars($equipo['equipo']) . '</td>
        <td>' . htmlspecialchars($equipo['proveedor']) . '</td>
        <td>' . htmlspecialchars($equipo['ubicacion']) . '</td>
        <td>' . htmlspecialchars($equipo['f_inicio_garantia']) . '</td>
        <td>' . htmlspecialchars($equipo['f_final_garantia']) . '</td>
        <td>' . htmlspecialchars($equipo['comentarios']) . '</td>
    </tr>';
}

$html .= '
    </table>
</body>
</html>';

// Configuración de Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true); // Habilitar el soporte para PHP dentro del contenido HTML
$dompdf = new Dompdf($options);

// Cargar el contenido HTML
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño y la orientación del papel
$dompdf->setPaper('A4', 'landscape');

// Renderizar el HTML como PDF
$dompdf->render();

// Nombre del archivo PDF para descarga
$nombre_archivo = 'reporte_equipos_generales.pdf';

// Enviar el PDF generado para descarga
$dompdf->stream($nombre_archivo, array('Attachment' => true));
?>
