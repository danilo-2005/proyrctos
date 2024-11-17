<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require_once "../php/main.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// Conexión a la base de datos
$conexion = conexion();
if (!$conexion) {
    die("Error de conexión a la base de datos.");
}

// Consulta SQL para obtener todos los equipos generales
$sql = "SELECT * FROM equipos_generales";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($equipos)) {
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

