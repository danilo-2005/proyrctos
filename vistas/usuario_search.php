<?php
// Mostrar errores para debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importar archivos necesarios
require_once "../inc/session_start.php";
require_once "../php/main.php";

// Obtener y limpiar la búsqueda
$busqueda = isset($_POST['searchQuery']) ? limpiar_cadena($_POST['searchQuery']) : '';
$pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$registros = 10; // Número de registros por página
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$url = "index.php?vista=usuario_buscar&page="; // URL para paginación

$tabla = "";

// Validar la búsqueda y construir las consultas SQL
if ($busqueda !== "") {
    $consulta_datos = "SELECT * FROM usuario 
                       WHERE usuario_id != :session_id 
                         AND (usuario_nombre LIKE :search 
                         OR usuario_apellido LIKE :search 
                         OR usuario_usuario LIKE :search 
                         OR usuario_email LIKE :search) 
                       ORDER BY usuario_nombre ASC 
                       LIMIT :inicio, :registros";

    $consulta_total = "SELECT COUNT(usuario_id) FROM usuario 
                       WHERE usuario_id != :session_id 
                         AND (usuario_nombre LIKE :search 
                         OR usuario_apellido LIKE :search 
                         OR usuario_usuario LIKE :search 
                         OR usuario_email LIKE :search)";
} else {
    $consulta_datos = "SELECT * FROM usuario 
                       WHERE usuario_id != :session_id 
                       ORDER BY usuario_nombre ASC 
                       LIMIT :inicio, :registros";

    $consulta_total = "SELECT COUNT(usuario_id) FROM usuario 
                       WHERE usuario_id != :session_id";
}

// Conexión a la base de datos
$conexion = conexion();

// Preparar y ejecutar consulta de datos
$consulta = $conexion->prepare($consulta_datos);
$consulta->bindValue(':session_id', $_SESSION['id'], PDO::PARAM_INT);
$consulta->bindValue(':search', "%$busqueda%", PDO::PARAM_STR);
$consulta->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$consulta->bindValue(':registros', $registros, PDO::PARAM_INT);
$consulta->execute();

$datos = $consulta->fetchAll();

// Preparar y ejecutar consulta total
$consulta_total = $conexion->prepare($consulta_total);
$consulta_total->bindValue(':session_id', $_SESSION['id'], PDO::PARAM_INT);
$consulta_total->bindValue(':search', "%$busqueda%", PDO::PARAM_STR);
$consulta_total->execute();

$total = (int) $consulta_total->fetchColumn();

// Calcular el número de páginas
$Npaginas = ceil($total / $registros);

// Construir la tabla
$tabla .= '
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
';

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;

    foreach ($datos as $rows) {
        $tabla .= '
            <tr class="has-text-centered">
                <td>' . $contador . '</td>
                <td>' . htmlspecialchars($rows['usuario_nombre']) . '</td>
                <td>' . htmlspecialchars($rows['usuario_apellido']) . '</td>
                <td>' . htmlspecialchars($rows['usuario_usuario']) . '</td>
                <td>' . htmlspecialchars($rows['usuario_email']) . '</td>
                <td>
                    <a href="index.php?vista=user_update&user_id_up=' . $rows['usuario_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="' . $url . '&user_id_del=' . $rows['usuario_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$tabla .= '</tbody></table></div>';

if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando usuarios <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

$conexion = null;
echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
