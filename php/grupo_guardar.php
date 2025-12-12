<?php
require_once "main.php";

// Almacenando datos
$semestre = isset($_POST['semestre']) ? limpiar_cadena($_POST['semestre']) : '';
$especialidad = isset($_POST['especialidad']) ? limpiar_cadena($_POST['especialidad']) : '';

// Verificando campos obligatorios
if ($semestre == "" || $especialidad == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios.
        </div>
    ';
    exit();
}

// Validar que los valores estén entre las opciones permitidas
$semestres_permitidos = ["I","II","III","IV","V","VI"];
$especialidades_permitidas = [
    "Contabilidad",
    "Electricidad",
    "Mantenimiento Automotriz",
    "Programacion",
    "Ofimatica",
    "Laboratorista Quimico"
];

if (!in_array($semestre, $semestres_permitidos, true)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Semestre no válido.
        </div>
    ';
    exit();
}

if (!in_array($especialidad, $especialidades_permitidas, true)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Especialidad no válida.
        </div>
    ';
    exit();
}

// Guardando datos (por default grupo está activo)
$guardar_grupo = conexion();
$guardar_grupo = $guardar_grupo->prepare("INSERT INTO grupos(semestre, especialidad) VALUES(:semestre, :especialidad)");

$marcadores = [
    ":semestre" => $semestre,
    ":especialidad" => $especialidad
];

$guardar_grupo->execute($marcadores);

if ($guardar_grupo->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡GRUPO REGISTRADO!</strong><br>
            El grupo se ha registrado con éxito en el sistema.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el grupo, por favor intente nuevamente.
        </div>
    ';
}

$guardar_grupo = null;
?>