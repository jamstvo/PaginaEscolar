<?php
// Horas de clases
$horas_clases = ['07:00','07:50','08:40','09:30','09:50','10:40','11:30','11:40','12:30','13:20','14:10'];
$dias = ['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'];

// Convertimos $q en array
$horario = $q->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='table is-fullwidth is-striped'>";
echo "<tr><th>Hora</th>";
foreach($dias as $dia) echo "<th>$dia</th>";
echo "</tr>";

foreach($horas_clases as $hora){
    $hora_fin = date("H:i", strtotime($hora." +50 minutes"));
    echo "<tr>";
    echo "<td>$hora - $hora_fin</td>";

    foreach($dias as $dia){
        $cell = '---';
        foreach($horario as $row){
            $hora_db = substr($row['hora_inicio'],0,5); // normalizar HH:MM
            if($row['dia']==$dia && $hora_db==$hora){
                if(isset($grupo_id)) { // POR GRUPO
                    $cell = "{$row['materia']} ({$row['nombre']} {$row['apellido']})";
                } elseif(isset($docente_id)) { // POR DOCENTE
                    $cell = "{$row['materia']} (Sem {$row['semestre']} {$row['especialidad']})";
                } else { // GENERAL
                    $cell = "{$row['materia']} ({$row['docente_nombre']} {$row['docente_apellido']})<br>Sem {$row['semestre']} {$row['especialidad']}";
                }
                break;
            }
        }
        echo "<td>$cell</td>";
    }

    echo "</tr>";
}
echo "</table>";

