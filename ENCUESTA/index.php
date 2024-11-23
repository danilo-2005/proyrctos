<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo Excel</title>
</head>
<body>
    <h1>Subir Archivo Excel</h1>
    <form action="procesar_excel.php" method="post" enctype="multipart/form-data">
        <label for="excelFile">Seleccione el archivo Excel:</label>
        <input type="file" name="excelFile" id="excelFile" accept=".xls,.xlsx" required>
        <button type="submit">Subir y Procesar</button>
    </form>
</body>
</html>
