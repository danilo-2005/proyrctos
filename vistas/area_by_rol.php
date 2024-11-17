<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./php/main.php";

// Verificar si se ha seleccionado un área y un rol
$area_id = isset($_GET['area_id']) ? $_GET['area_id'] : '';
$rol_id = isset($_GET['rol_id']) ? $_GET['rol_id'] : '';

// Definir URL base
$base_url = "index.php?view=area_by_rol";
$url = $base_url . ($area_id ? "&area_id=" . urlencode($area_id) : "");

// Conexión a la base de datos
$conexion = conexion();

// Obtener áreas
$areas = $conexion->query("SELECT DISTINCT QAREA FROM TB_DOCENTES ORDER BY QAREA ASC");

// Obtener roles basados en el área seleccionada
$ubicaciones = [];
if ($area_id != '') {
    $ubicaciones_query = $conexion->prepare("SELECT DISTINCT QCARGO FROM TB_DOCENTES WHERE QAREA = :area_id ORDER BY QCARGO ASC");
    $ubicaciones_query->bindParam(':area_id', $area_id);
    $ubicaciones_query->execute();
    $ubicaciones = $ubicaciones_query->fetchAll();
}
?>

<!-- Incluyendo Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-container--default .select2-selection--single {
        width: 250px !important;
        height: 40px;
        border-color: #D5D5D5;
        border-radius: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.5em;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 2.5em;
    }
    .select-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    /* Custom CSS for buttons */
    .custom-button1, .deleteButton, .custom-button11, .custom-button111 {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #2c3e50;
        margin-right: 5px;
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid transparent;
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
    }
    /* Different button colors */
    .deleteButton { color: #e74c3c; }
    .custom-button11 { color: #0c7a03; }
    .custom-button111 { color: #034b7a; }

    /* Hover effects */
    .custom-button1:hover, .deleteButton:hover, .custom-button11:hover, .custom-button111:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    /* Estilos para ajustar la tabla */
    .table-container {
        overflow-x: auto; /* Permitir scroll horizontal si es necesario */
    }

    .table {
        width: auto; /* Ajustar el ancho de la tabla al contenido */
        table-layout: auto; /* Permitir que el ancho de las columnas sea dinámico */
        white-space: nowrap; /* Evitar que el texto en las celdas se rompa */
    }

    .table td, .table th {
        padding: 10px;
        text-align: center;
    }

    .table th:nth-child(1), .table td:nth-child(1) {
        width: 50px; /* Fijar el ancho de la columna de índice (número de fila) */
    }
</style>

<div class="container is-fluid mb-6">
    <h1 class="title">Ubicaciones</h1>
    <h2 class="subtitle">Lista de ubicaciones por área</h2>
</div>

<div class="container pb-6 pt-6">
    <div class="select-container">
        <!-- Select de áreas -->
        <?php if ($areas->rowCount() > 0): ?>
            <select id="blockSelect" class="js-example-basic-single">
                <option value="">Seleccione un área</option>
                <?php foreach ($areas->fetchAll() as $row): ?>
                    <option value="<?= $row['QAREA']; ?>" <?= $row['QAREA'] == $area_id ? 'selected' : ''; ?>>
                        <?= $row['QAREA']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <p class="has-text-centered">No hay áreas registradas</p>
        <?php endif; ?>

        <!-- Select de ubicaciones -->
        <?php if ($area_id): ?>
            <select id="locationSelect" class="js-example-basic-single">
                <option value="">Seleccione una ubicación</option>
                <option value="todos" <?= $rol_id === 'todos' ? 'selected' : ''; ?>>TODOS</option>
                <?php foreach ($ubicaciones as $row): ?>
                    <option value="<?= $row['QCARGO']; ?>" <?= $row['QCARGO'] == $rol_id ? 'selected' : ''; ?>>
                        <?= $row['QCARGO']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </div>

    <div class="column">
        <!-- Mostrar resultados filtrados -->
        <?php
        if ($area_id != '') {
            if ($rol_id && $rol_id != 'todos') {
                $consulta_datos = $conexion->prepare("
                    SELECT *, 
                    CONCAT(QNOMBRES, ' ', COALESCE(QAPELLIDOS, '')) AS nombre_completo
                    FROM TB_DOCENTES 
                    WHERE QAREA = :area_id 
                    AND QCARGO = :rol_id 
                    ORDER BY QNOMBRES ASC
                ");
                $consulta_datos->bindParam(':area_id', $area_id);
                $consulta_datos->bindParam(':rol_id', $rol_id);
            } else {
                $consulta_datos = $conexion->prepare("
                    SELECT *, 
                    CONCAT(QNOMBRES, ' ', COALESCE(QAPELLIDOS, '')) AS nombre_completo
                    FROM TB_DOCENTES 
                    WHERE QAREA = :area_id 
                    ORDER BY QNOMBRES ASC
                ");
                $consulta_datos->bindParam(':area_id', $area_id);
            }
            $consulta_datos->execute();
        } else {
            // Consulta cuando no se ha seleccionado ningún área
            $consulta_datos = $conexion->query("
                SELECT *, 
                CONCAT(QNOMBRES, ' ', COALESCE(QAPELLIDOS, '')) AS nombre_completo
                FROM TB_DOCENTES 
                ORDER BY QCARGO ASC, QNOMBRES ASC
            ");
        }

        if ($consulta_datos->rowCount() > 0): ?>
            <div class="table-container">
                <table class="table is-bordered is-striped is-narrow is-hoverable">
                    <thead>
                        <tr class="has-text-centered">
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>Cargo</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consulta_datos->fetchAll() as $contador => $rows): ?>
                            <tr class="has-text-centered">
                                <td><?= $contador + 1; ?></td>
                                <td><?= $rows['nombre_completo']; ?></td>
                                <td><?= $rows['QCARGO']; ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="has-text-centered">No hay categorías registradas en esta área</p>
        <?php endif;

        $conexion = null;
        ?>
    </div>
</div>

<!-- Incluyendo Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: "Seleccione una opción",
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontró el resultado escrito. Inténtelo de nuevo.";
                }
            }
        }).on('change', function() {
            var blockId = $('#blockSelect').val();
            var locationId = $('#locationSelect').val();
            var url = "index2.php?view=area_by_rol";

            if (blockId !== "") {
                url += "&area_id=" + blockId;
            }
            if (locationId !== "" && locationId !== "todos") {
                url += "&rol_id=" + locationId;
            }
            
            window.location.href = url;
        });
    });
</script>
