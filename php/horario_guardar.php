<?php
require_once "main.php";

$id_grupo   = limpiar_cadena($_POST['id_grupo']);
$id_docente = limpiar_cadena($_POST['id_docente']);
$id_materia = limpiar_cadena($_POST['id_materia']);
$dia        = limpiar_cadena($_POST['dia']);
$hora_inicio = limpiar_cadena($_POST['hora_inicio']);

// ⏱ convertir a timestamp
$inicio = strtotime($hora_inicio);
$fin = strtotime("+50 minutes", $inicio);

// límites generales
$min_inicio = strtotime("07:00");
$max_fin = strtotime("14:10");

// recesos
$recesos = [
    ["09:30", "09:50"],
    ["11:30", "11:40"]
];

// 1️⃣ validar rango general
if ($inicio < $min_inicio || $fin > $max_fin) {
    echo '
    <div class="notification is-danger is-light">
        El horario debe estar entre 07:00 y 14:10.
    </div>';
    exit();
}

// 2️⃣ validar cruces con recesos
foreach ($recesos as $r) {
    $r_inicio = strtotime($r[0]);
    $r_fin = strtotime($r[1]);

    if ($inicio < $r_fin && $fin > $r_inicio) {
        echo '
        <div class="notification is-danger is-light">
            La clase no puede cruzar un receso (' . $r[0] . ' - ' . $r[1] . ').
        </div>';
        exit();
    }
}

// 3️⃣ validar choques (grupo o docente)
$conexion = conexion();
$check = $conexion->query("
    SELECT id FROM horarios
    WHERE dia='$dia'
    AND status='ACTIVO'
    AND (
        id_grupo='$id_grupo' OR id_docente='$id_docente'
    )
    AND (
        hora_inicio < '".date("H:i", $fin)."'
        AND hora_fin > '".date("H:i", $inicio)."'
    )
");

if ($check->rowCount() > 0) {
    echo '
    <div class="notification is-danger is-light">
        Existe un conflicto de horario con el grupo o docente.
    </div>';
    exit();
}

// 4️⃣ guardar
$guardar = $conexion->prepare("
    INSERT INTO horarios
    (id_grupo, id_docente, id_materia, dia, hora_inicio, hora_fin)
    VALUES (:g, :d, :m, :dia, :hi, :hf)
");

$guardar->execute([
    ":g" => $id_grupo,
    ":d" => $id_docente,
    ":m" => $id_materia,
    ":dia" => $dia,
    ":hi" => date("H:i", $inicio),
    ":hf" => date("H:i", $fin)
]);

echo '
<div class="notification is-success is-light">
    Clase registrada correctamente.
</div>';
