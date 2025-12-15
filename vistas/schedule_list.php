<?php require_once "./php/main.php"; ?>

<div class="container is-fluid mb-6">
    <h1 class="title">Horarios</h1>
    <h2 class="subtitle">Consulta de horarios</h2>
</div>

<div class="container pb-6 pt-6">

<form method="GET">

    <input type="hidden" name="vista" value="schedule_list">

    <div class="columns">
        <div class="column">
            <label>Tipo de horario</label>
            <div class="select is-fullwidth">
                <select name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="GENERAL" <?= (isset($_GET['tipo']) && $_GET['tipo']=='GENERAL')?'selected':'' ?>>General</option>
                    <option value="GRUPO" <?= (isset($_GET['tipo']) && $_GET['tipo']=='GRUPO')?'selected':'' ?>>Por grupo</option>
                    <option value="DOCENTE" <?= (isset($_GET['tipo']) && $_GET['tipo']=='DOCENTE')?'selected':'' ?>>Por docente</option>
                </select>
            </div>
        </div>
    </div>

    <div class="has-text-centered mt-4">
        <button class="button is-info is-rounded">Consultar</button>
    </div>

</form>

<hr>

<?php
if(isset($_GET['tipo'])){
    $conexion = conexion();
    $tipo = strtoupper(limpiar_cadena($_GET['tipo']));

    if($tipo=='OFICIAL'){
        echo "<div class='notification is-warning'>El horario oficial aún no está disponible.</div>";
    }

    elseif($tipo=='GENERAL'){
        $dias = ['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'];

        // Obtener todos los grupos activos
        $grupos = $conexion->query("SELECT id, semestre, especialidad FROM grupos WHERE status='ACTIVO' ORDER BY semestre, especialidad")->fetchAll(PDO::FETCH_ASSOC);

        // Obtener todos los horarios activos
        $horarios = $conexion->query("
            SELECT h.*, g.semestre, g.especialidad, d.nombre AS docente_nombre, d.apellido AS docente_apellido, m.nombre AS materia
            FROM horarios h
            JOIN grupos g ON h.id_grupo=g.id
            JOIN docentes d ON h.id_docente=d.id
            JOIN materias m ON h.id_materia=m.id
            WHERE h.status='ACTIVO'
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Horas de clase
        $horas_clases = ['07:00','07:50','08:40','09:30','09:50','10:40','11:30','11:40','12:30','13:20','14:10'];

        foreach($dias as $dia){
            echo "<h3 class='title is-4 mt-5'>$dia</h3>";

            echo "<table class='table is-bordered is-striped is-fullwidth'>";
            echo "<tr><th>Hora</th>";
            foreach($grupos as $g){
                $col_name = "Sem {$g['semestre']} {$g['especialidad']}";
                echo "<th>{$col_name}</th>";
            }
            echo "</tr>";

            foreach($horas_clases as $hora){
                $hora_fin = date("H:i", strtotime($hora." +50 minutes"));
                echo "<tr>";
                echo "<td>$hora - $hora_fin</td>";

                foreach($grupos as $g){
                    $cell = '---';
                    foreach($horarios as $h){
                        $hora_db = substr($h['hora_inicio'],0,5); // HH:MM
                        if($h['dia']==$dia && $hora_db==$hora && $h['id_grupo']==$g['id']){
                            $cell = "{$h['materia']} ({$h['docente_nombre']} {$h['docente_apellido']})";
                            break;
                        }
                    }
                    echo "<td>$cell</td>";
                }

                echo "</tr>";
            }


            echo "</table>";
        }
    }

    elseif($tipo=='GRUPO' && !empty($_GET['grupo_id'])){
        $grupo_id = (int) $_GET['grupo_id'];
        $q = $conexion->query("
            SELECT h.*, d.nombre, d.apellido, m.nombre AS materia, g.semestre, g.especialidad
            FROM horarios h
            JOIN docentes d ON h.id_docente=d.id
            JOIN materias m ON h.id_materia=m.id
            JOIN grupos g ON h.id_grupo=g.id
            WHERE h.id_grupo='$grupo_id' AND h.status='ACTIVO'
        ");
        include "./php/horario_grid.php";
    }

    elseif($tipo=='DOCENTE' && !empty($_GET['docente_id'])){
        $docente_id = (int) $_GET['docente_id'];
        $q = $conexion->query("
            SELECT h.*, g.semestre, g.especialidad, m.nombre AS materia
            FROM horarios h
            JOIN grupos g ON h.id_grupo=g.id
            JOIN materias m ON h.id_materia=m.id
            WHERE h.id_docente='$docente_id' AND h.status='ACTIVO'
        ");
        include "./php/horario_grid.php";
    }
}
?>

</div>
