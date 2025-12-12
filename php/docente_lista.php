<?php

    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    $tabla = "";

    $status_filter = isset($_GET['status_filter']) ? limpiar_cadena($_GET['status_filter']) : "ACTIVO";

    $condicion_status = "";
    if($status_filter == "ACTIVO"){
        $condicion_status = "AND status='ACTIVO'";
    }elseif($status_filter == "INACTIVO"){
        $condicion_status = "AND status='INACTIVO'";
    }else{
        $condicion_status = ""; // TODOS
    }


    if (isset($busqueda) && $busqueda != "") {
        $consulta_datos = "
        SELECT docentes.*, usuarios.correo 
        FROM docentes
        INNER JOIN usuarios ON docentes.usuario_id = usuario.id
        WHERE docentes.id!='".$_SESSION['id']."' 
        AND (docentes.nombre LIKE '%$busqueda%' 
        OR docentes.apellido LIKE '%$busqueda%' 
        OR docentes.telefono LIKE '%$busqueda%'
        OR docentes.especialidad LIKE '%$busqueda%'
        OR usuarios.correo LIKE '%$busqueda%')
        $condicion_status
        ORDER BY docentes.nombre ASC
        LIMIT $inicio, $registros";

        $consulta_total = "
        SELECT COUNT(docente.id) 
        FROM docentes
        INNER JOIN usuarios ON docentes.usuario_id = usuarios.id
        WHERE docentes.id!='".$_SESSION['id']."'
        AND (docentes.nombre LIKE '%$busqueda%'
        OR docentes.apellido LIKE '%$busqueda%'
        OR docentes.telefono LIKE '%$busqueda%'
        OR docentes.especialidad LIKE '%$busqueda%'
        OR usuarios.correo LIKE '%$busqueda%')
        $condicion_status";

    } else {
        $consulta_datos = "
        SELECT docentes.*, usuarios.correo 
        FROM docentes
        INNER JOIN usuarios ON docentes.usuario_id = usuarios.id
        WHERE docentes.id!='".$_SESSION['id']."'
        $condicion_status
        ORDER BY docentes.nombre ASC
        LIMIT $inicio, $registros";

        $consulta_total = "
        SELECT COUNT(docentes.id)
        FROM docentes
        INNER JOIN usuarios ON docentes.usuario_id = usuarios.id
        WHERE docentes.id!='".$_SESSION['id']."'
        $condicion_status";

    }

    $conexion = conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total / $registros);

    $tabla .= '
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Especialidad</th>
                        <th>Status</th>
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
                    <td>' . $rows['correo'] . '</td>
                    <td>' . $rows['nombre'] . '</td>
                    <td>' . $rows['apellido'] . '</td>
                    <td>' . $rows['telefono'] . '</td>
                    <td>' . $rows['especialidad'] . '</td>
                    <td>' . $rows['status'] . '</td>
                    <td>
                        <a href="index.php?vista=teacher_update&teacher_id_up=' . $rows['id'] . '" 
                        class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="./php/docente_status.php?id='.$rows['id'].'" 
                        class="button '.($rows['status']=="ACTIVO" ? "is-danger" : "is-warning").' is-rounded is-small">
                        '.($rows['status']=="ACTIVO" ? "Desactivar" : "Activar").'
                        </a>
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
                    <td colspan="8">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        } else {
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="8">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $tabla .= '</tbody></table></div>';

    if ($total >= 1 && $pagina <= $Npaginas) {
        $tabla .= '
            <p class="has-text-right">Mostrando docentes <strong>' . $pag_inicio . '</strong> al 
            <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>
        ';
    }

    $conexion = null;
    echo $tabla;

    if ($total >= 1 && $pagina <= $Npaginas) {
        echo paginador_tablas($pagina, $Npaginas, $url, 7);
    }
?>