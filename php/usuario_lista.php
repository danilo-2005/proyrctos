<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT * FROM tb_usuarios WHERE ((USUARIO_ID!='" . $_SESSION['id'] . "') AND (USUARIO_NOMBRES LIKE '%$busqueda%' OR USUARIO_APELLIDOS LIKE '%$busqueda%' OR USUARIO_ROL LIKE '%$busqueda%' OR USUARIO_USUARIO LIKE '%$busqueda%' OR USUARIO_ESTADO LIKE '%$busqueda%')) ORDER BY USUARIO_NOMBRES ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(USUARIO_ID) FROM usuario WHERE ((USUARIO_ID!='" . $_SESSION['id'] . "') AND (USUARIO_NOMBRES LIKE '%$busqueda%' OR USUARIO_APELLIDOS LIKE '%$busqueda%' OR USUARIO_ROL LIKE '%$busqueda%' OR USUARIO_USUARIO LIKE '%$busqueda%' OR USUARIO_ESTADO LIKE '%$busqueda%'))";
} else {
    $consulta_datos = "SELECT * FROM tb_usuarios WHERE USUARIO_ID!='" . $_SESSION['id'] . "' ORDER BY USUARIO_NOMBRES ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(USUARIO_ID) FROM tb_usuarios WHERE USUARIO_ID!='" . $_SESSION['id'] . "'";
}

$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();

$Npaginas = ceil($total / $registros);

?>

<div class="table-container">
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Rol</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($total >= 1 && $pagina <= $Npaginas): ?>
                <?php 
                $contador = $inicio + 1;
                foreach ($datos as $rows): ?>
                    <tr>
                        <td><?php echo $contador; ?></td>
                        <td><?php echo htmlspecialchars($rows['USUARIO_NOMBRES']); ?></td>
                        <td><?php echo htmlspecialchars($rows['USUARIO_APELLIDOS']); ?></td>
                        <td><?php echo htmlspecialchars($rows['USUARIO_ROL']); ?></td>
                        <td><?php echo htmlspecialchars($rows['USUARIO_USUARIO']); ?></td>
                        <td><?php echo htmlspecialchars($rows['USUARIO_ESTADO']); ?></td>
                        <td>
                            <a href="index.php?vista=user_update&user_id_up=<?php echo $rows['USUARIO_ID']; ?>" class="btn btn-update">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo $url . $pagina . '&user_id_del=' . $rows['USUARIO_ID']; ?>" class="btn btn-delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                $contador++;
                endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No hay registros disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
/* Contenedor general */
.table-container {
    margin: 20px auto;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-x: auto; /* Para móviles */
}

/* Estilo de la tabla */
.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Poppins', sans-serif;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
}

.styled-table thead {
    background: #613b9c;
    color: #ffffff;
}

.styled-table th{
    text-align: center;
    padding: 10px 15px;
    font-size: 14px;
    color: #ffffff;
} 
.styled-table td {
    text-align: center;
    padding: 10px 15px;
    font-size: 14px;
}

.styled-table tbody tr:nth-child(even) {
    background: #f7f7f7;
}

.styled-table tbody tr:hover {
    background: #e6e6fa;
}

.styled-table th {
    text-transform: uppercase;
    font-size: 14px;
    font-weight: bold;
}

.text-center {
    text-align: center;
}

/* Estilos de los botones */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn i {
    margin-right: 5px;
}

.btn-update {
    background: #27ae60;
    color: #ffffff;
    border: 1px solid #27ae60;
}

.btn-update:hover {
    background: #2ecc71;
    border-color: #2ecc71;
}

.btn-delete {
    background: #e74c3c;
    color: #ffffff;
    border: 1px solid #e74c3c;
}

.btn-delete:hover {
    background: #c0392b;
    border-color: #c0392b;
}
</style>
