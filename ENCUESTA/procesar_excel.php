<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Configuración de la base de datos
$host = 'srv1598.hstgr.io';
$dbname = 'u239335834_ENCUESTA';
$user = 'u239335834_SUPERADMIN';
$password = 'EncuestasA2025';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Función para normalizar datos
function normalizarDatos($nombre, $email) {
    $nombre = mb_strtoupper($nombre, 'UTF-8'); // Nombres a mayúsculas
    $email = mb_strtolower($email, 'UTF-8');  // Correos a minúsculas
    return ['nombre' => $nombre, 'email' => $email];
}

// Verificar si se subió el archivo
if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $fileName = $_FILES['excelFile']['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (in_array($fileExtension, ['xls', 'xlsx'])) {
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Comenzar una transacción para insertar los datos
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO base_a_2025 (nombre, email, telefono, programa, colegio, municipio) VALUES (?, ?, ?, ?, ?, ?)");

            foreach ($data as $index => $row) {
                if ($index === 0) {
                    // Saltar la primera fila (cabeceras)
                    continue;
                }

                // Obtener valores de las columnas
                $nombre = $row[0] ?? null;
                $email = $row[1] ?? null;
                $telefono = $row[2] ?? null;
                $programa = $row[3] ?? null;
                $colegio = $row[4] ?? null;
                $municipio= $row[5] ?? null;

                if ($nombre && $email && $telefono) {
                    // Normalizar los datos
                    $normalizados = normalizarDatos($nombre, $email);
                    $nombre = $normalizados['nombre'];
                    $email = $normalizados['email'];

                    // Insertar en la base de datos
                    $stmt->execute([$nombre, $email, $telefono, $programa, $colegio, $municipio]);
                }
            }

            // Confirmar la transacción
            $pdo->commit();
            echo "Archivo procesado e importado con éxito.";
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error al procesar el archivo: " . $e->getMessage();
        }
    } else {
        echo "Por favor, suba un archivo válido (.xls o .xlsx).";
    }
} else {
    echo "Error al subir el archivo.";
}
?>
