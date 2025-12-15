<?php
require_once "main.php";

/* ======================
   DATOS
====================== */

$grupo_id     = limpiar_cadena($_POST['grupo_id']);
$nombre       = limpiar_cadena($_POST['nombre']);
$semestre     = limpiar_cadena($_POST['semestre']);
$especialidad = limpiar_cadena($_POST['especialidad']);
$generacion   = limpiar_cadena($_POST['generacion']);
$anio_inicio  = limpiar_cadena($_POST['anio_inicio']);
$tutor_id     = limpiar_cadena($_POST['tutor_id']);

/* ======================
   VALIDACIONES
====================== */

if ($grupo_id=="" || $nombre=="" || $semestre=="" || $especialidad=="" || $generacion=="" || $anio_inicio=="") {
    exit('<div class="notification is-danger is-light">Campos obligatorios incompletos.</div>');
}

if (verificar_datos("[0-9]{1,10}", $grupo_id)) exit("ID no válido");
if (verificar_datos("[A-Z0-9]{1,2}", $nombre)) exit("Nombre no válido");
if (verificar_datos("[1-6]", $semestre)) exit("Semestre no válido");
if (verificar_datos("[0-9\-]{9}", $generacion)) exit("Generación no válida");
if (verificar_datos("[0-9]{4}", $anio_inicio)) exit("Año de inicio no válido");

/* Validar tutor si existe */
if ($tutor_id != "") {
    if (verificar_datos("[0-9]{1,10}", $tutor_id)) exit("Tutor no válido");

    $check = conexion()->query("
        SELECT id FROM docentes 
        WHERE id='$tutor_id' AND status='ACTIVO'
    ");
    if ($check->rowCount() == 0) {
        exit("El tutor seleccionado no existe");
    }
}

/* ======================
   ACTUALIZAR
====================== */

$conexion = conexion();

$sql = "
    UPDATE grupos SET
        nombre = :nombre,
        semestre = :semestre,
        especialidad = :especialidad,
        generacion = :generacion,
        anio_inicio = :anio_inicio,
        tutor_id = :tutor_id
    WHERE id = :id
";

$conexion->prepare($sql)->execute([
    ":nombre"       => $nombre,
    ":semestre"     => $semestre,
    ":especialidad" => $especialidad,
    ":generacion"   => $generacion,
    ":anio_inicio"  => $anio_inicio,
    ":tutor_id"     => ($tutor_id != "") ? $tutor_id : null,
    ":id"           => $grupo_id
]);

echo '
    <div class="notification is-info is-light">
        <strong>¡GRUPO ACTUALIZADO!</strong><br>
        Los datos se actualizaron correctamente.
    </div>
';

$conexion = null;
