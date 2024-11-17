<?php
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $tabla="";

    if(isset($busqueda) && $busqueda!=""){

        $consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_rol LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_rol LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%'))";

    }else{

        $consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."'";
        
    }

    $conexion=conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas =ceil($total/$registros);

    $tabla.='
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Rol</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $tabla.='
                <tr class="has-text-centered">
                    <td>'.$contador.'</td>
                    <td>'.$rows['usuario_nombre'].'</td>
                    <td>'.$rows['usuario_apellido'].'</td>
                    <td>'.$rows['usuario_rol'].'</td>
                    <td>'.$rows['usuario_usuario'].'</td>
                    <td>'.$rows['usuario_email'].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_up='.$rows['usuario_id'].'" class="custom-button1">
                            <i class="fas fa-edit"></i> Actualizar
                        </a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['usuario_id'].'" class="deleteButton">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    }else{
        if($total>=1){
            $tabla.='
                <tr class="has-text-centered">
                    <td colspan="7">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4 custom-button">
                            <i class="fas fa-sync-alt"></i> Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $tabla.='
                <tr class="has-text-centered">
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $tabla.='</tbody></table></div>';

    if($total>0 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion=null;
    echo $tabla;

    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,7);
    }
?>
<style>
        /* Custom CSS for Buttons */
        .deleteButton,.custom-button1 {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px; /* Adjust the font size */
            color: #2c3e50; /* Dark color for text */
            text-decoration: none;
            margin-right: 5px; /* Space between buttons */
            padding: 5px 10px; /* Padding for button-like appearance */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid transparent; /* Button border */
            transition: color 0.3s ease, text-decoration 0.3s ease, background-color 0.3s ease, border-color 0.3s ease; /* Smooth transition */
        }

        .custom-button1 i {
            margin-right: 8px; /* Space between icon and text */
            color: #2c3e50; /* Dark color for icons */
            transition: color 0.3s ease; /* Smooth transition for icon color */
        }

        .custom-button1:hover {
            color: #2980b9; /* Change text color on hover */
            text-decoration: underline; /* Underline text on hover */
           
        }

        .custom-button1:hover i {
            color: #2980b9; /* Change icon color on hover */
           
        }

        /* Specific style for the "Eliminar" button */
        .deleteButton {
            color: #e74c3c; /* Initial color */
             /* Initial border color */
        }

        .deleteButton i {
            color: #e74c3c; /* Initial icon color */
        }

        .deleteButton:hover {
            color: #e74c3c; /* Red color on hover */
            
           
        }

        .deleteButton:hover i {
            color: #e74c3c; /* Red icon color on hover */
        }

</style>