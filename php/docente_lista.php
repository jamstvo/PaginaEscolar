<?php

    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    $tabla = "";

    // Buscar en la tabla DOCENTE (no usuario)
    if (isset($busqueda) && $busqueda != "") {
        $consulta_datos = "SELECT * FROM docente WHERE (nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%') ORDER BY nombre ASC LIMIT $inicio, $registros";
        $consulta_total = "SELECT COUNT(id) FROM docente WHERE (nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%')";
    } else {
        $consulta_datos = "SELECT * FROM docente ORDER BY nombre ASC LIMIT $inicio, $registros";
        $consulta_total = "SELECT COUNT(id) FROM docente";
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
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Estado</th>
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
                    <td>' . $rows['nombre'] . '</td>
                    <td>' . $rows['apellido'] . '</td>
                    <td>' . $rows['correo'] . '</td>
                    <td>' . $rows['telefono'] . '</td>
                    <td>' . $rows['estado'] . '</td>
                    <td>
                        <a href="index.php?vista=teacher_update&teacher_id_up=' . $rows['id'] . '" 
                        class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="' . $url . $pagina . '&docente_id_del=' . $rows['id'] . '" 
                        class="button is-danger is-rounded is-small">Inactivar</a>
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