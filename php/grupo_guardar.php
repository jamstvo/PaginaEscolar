<?php
require_once "main.php";

// Almacenando datos
$nombre       = limpiar_cadena($_POST['nombre']);
$semestre     = limpiar_cadena($_POST['semestre']);
$especialidad = limpiar_cadena($_POST['especialidad']);
$generacion   = limpiar_cadena($_POST['generacion']);
$anio_inicio  = limpiar_cadena($_POST['anio_inicio']);
$tutor_id = limpiar_cadena($_POST['tutor_id']);

// Verificar campos obligatorios
if ($nombre=="" || $semestre=="" || $especialidad=="" || $generacion=="" || $anio_inicio=="") {
    echo '
        <div class="notification is-danger is-light">
            <strong>Error</strong><br>
            No has llenado todos los campos obligatorios.
        </div>
    ';
    exit();
}

// Validaciones
if (verificar_datos("[A-Z0-9]{1,2}", $nombre)) {
    exit("Nombre no válido");
}

if (verificar_datos("[0-9\-]{9}", $generacion)) {
    exit("Generación no válida");
}

if (verificar_datos("[0-9]{4}", $anio_inicio)) {
    exit("Año de inicio no válido");
}

if (verificar_datos("[0-9]{1,10}", $tutor_id)) {
    exit("Tutor no válido");
}

//Validar semestre

    $mes_actual = date("n"); // 1 a 12

    if ($mes_actual >= 1 && $mes_actual <= 6) {
        $ciclo = "par";
    } elseif ($mes_actual >= 8 && $mes_actual <= 12) {
        $ciclo = "impar";
    } else {
        echo '
            <div class="notification is-warning is-light">
                No se pueden registrar grupos en periodo vacacional.
            </div>
        ';
        exit();
    }

    $permitidos = ($ciclo === "par")
        ? ["2", "4", "6"]
        : ["1", "3", "5"];

    if (!in_array($semestre, $permitidos)) {
        echo '
            <div class="notification is-danger is-light">
                Semestre no permitido en el ciclo actual.
            </div>
        ';
        exit();
    }


// Validar el tutor
$check_tutor = conexion();
$check_tutor = $check_tutor->query(
    "SELECT id FROM docentes WHERE id='$tutor_id' AND status='ACTIVO'"
);

if ($check_tutor->rowCount() == 0) {
    exit("El tutor seleccionado no existe");
}
$check_tutor = null;


// Guardar grupo
$guardar_grupo = conexion();
$guardar_grupo = $guardar_grupo->prepare(
    "INSERT INTO grupos
    (nombre, semestre, especialidad, generacion, anio_inicio, tutor_id, status)
    VALUES
    (:nombre, :semestre, :especialidad, :generacion, :anio_inicio, :tutor_id, 'ACTIVO')"
);

$guardar_grupo->execute([
    ":nombre"       => $nombre,
    ":semestre"     => $semestre,
    ":especialidad" => $especialidad,
    ":generacion"   => $generacion,
    ":anio_inicio"  => $anio_inicio,
    ":tutor_id"     => $tutor_id
]);


if ($guardar_grupo->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡GRUPO REGISTRADO!</strong><br>
            El grupo se registró correctamente.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            Error al registrar el grupo.
        </div>
    ';
}

$guardar_grupo = null;
