<?php

$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

$status_filter = isset($_GET['status_filter']) ? limpiar_cadena($_GET['status_filter']) : "ACTIVO";

$condicion_status = "";
if($status_filter == "ACTIVO"){
    $condicion_status = "AND g.status='ACTIVO'";
}elseif($status_filter == "EGRESADO"){
    $condicion_status = "AND g.status='EGRESADO'";
}else{
    $condicion_status = ""; // TODOS
}

if (isset($busqueda) && $busqueda != "") {

    $consulta_datos = "
        SELECT 
            g.id,
            g.nombre,
            g.semestre,
            g.especialidad,
            g.generacion,
            g.anio_inicio,
            g.status,
            CONCAT(d.nombre,' ',d.apellido) AS tutor
        FROM grupos g
        LEFT JOIN docentes d ON g.tutor_id = d.id
        WHERE (
            g.nombre LIKE '%$busqueda%' OR
            g.semestre LIKE '%$busqueda%' OR
            g.especialidad LIKE '%$busqueda%' OR
            g.generacion LIKE '%$busqueda%' OR
            g.anio_inicio LIKE '%$busqueda%'
        )
        $condicion_status
        ORDER BY g.semestre ASC
        LIMIT $inicio, $registros
    ";

    $consulta_total = "
        SELECT COUNT(g.id)
        FROM grupos g
        LEFT JOIN docentes d ON g.tutor_id = d.id
        WHERE (
            g.nombre LIKE '%$busqueda%' OR
            g.semestre LIKE '%$busqueda%' OR
            g.especialidad LIKE '%$busqueda%' OR
            g.generacion LIKE '%$busqueda%' OR
            g.anio_inicio LIKE '%$busqueda%'
        )
        $condicion_status
    ";

} else {

    $consulta_datos = "
        SELECT 
            g.id,
            g.nombre,
            g.semestre,
            g.especialidad,
            g.generacion,
            g.anio_inicio,
            g.status,
            CONCAT(d.nombre,' ',d.apellido) AS tutor
        FROM grupos g
        LEFT JOIN docentes d ON g.tutor_id = d.id
        WHERE 1=1
        $condicion_status
        ORDER BY g.semestre ASC
        LIMIT $inicio, $registros
    ";

    $consulta_total = "
        SELECT COUNT(id)
        FROM grupos g
        WHERE 1=1
        $condicion_status
    ";
}


$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn();

$Npaginas = ceil($total / $registros);


$tabla .= '
<div class="table-container">
<table class="table is-bordered is-striped is-hoverable is-fullwidth">
    <thead>
        <tr class="has-text-centered">
            <th>#</th>
            <th>Nombre</th>
            <th>Semestre</th>
            <th>Especialidad</th>
            <th>Generación</th>
            <th>Año inicio</th>
            <th>Tutor</th>
            <th>Status</th>
            <th colspan="2">Opciones</th>
        </tr>
    </thead>
    <tbody>
';

if ($total >= 1 && $pagina <= $Npaginas) {

    $contador = $inicio + 1;
    $pag_inicio = $contador;

    foreach ($datos as $rows) {

        $tabla .= '
        <tr class="has-text-centered">
            <td>'.$contador.'</td>
            <td>'.$rows['nombre'].'</td>
            <td>'.$rows['semestre'].'</td>
            <td>'.$rows['especialidad'].'</td>
            <td>'.$rows['generacion'].'</td>
            <td>'.$rows['anio_inicio'].'</td>
            <td>'.($rows['tutor'] ?? '—').'</td>
            <td>'.$rows['status'].'</td>

            <td>
                <a href="index.php?vista=group_update&group_id_up='.$rows['id'].'"
                class="button is-success is-rounded is-small">
                    Actualizar
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
            <td colspan="10">
                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </td>
        </tr>
        ';
    } else {
        $tabla .= '
        <tr class="has-text-centered">
            <td colspan="10">
                No hay registros en el sistema
            </td>
        </tr>
        ';
    }
}

$tabla .= '</tbody></table></div>';


if ($total >= 1 && $pagina <= $Npaginas) {
    $tabla .= '
        <p class="has-text-right">
            Mostrando grupos <strong>'.$pag_inicio.'</strong> al
            <strong>'.$pag_final.'</strong> de un
            <strong>total de '.$total.'</strong>
        </p>
    ';
}

$conexion = null;
echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
