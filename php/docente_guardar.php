<?php
require_once "main.php";

// Almacenando datos
$usuario_id   = limpiar_cadena($_POST['usuario_id']);
$nombre       = limpiar_cadena($_POST['nombre']);
$apellido     = limpiar_cadena($_POST['apellido']);
$telefono     = limpiar_cadena($_POST['telefono']);
$especialidad = limpiar_cadena($_POST['especialidad']);

// Verificar campos obligatorios
if ($usuario_id == "" || $nombre == "" || $especialidad == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos obligatorios.
        </div>
    ';
    exit();
}

// Verificar integridad de usuario_id

if (verificar_datos("[0-9]{1,10}", $usuario_id)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>Error</strong><br>
            El usuario seleccionado no es válido.
        </div>
    ';
    exit();
}

// Verificar si usuario_id existe en la tabla usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT id FROM usuarios WHERE id = '$usuario_id' LIMIT 1");

if ($check_usuario->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>Error</strong><br>
            El usuario seleccionado no existe en el sistema.
        </div>
    ';
    exit();
}
$check_usuario = null;

// Verificar si este usuario ya tiene un docente asignado
$check_docente = conexion();
$check_docente = $check_docente->query("SELECT usuario_id FROM docentes WHERE usuario_id = '$usuario_id' LIMIT 1");

if ($check_docente->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>Error</strong><br>
            Este usuario ya está asignado a un docente.
        </div>
    ';
    exit();
}
$check_docente = null;

// Validaciones de texto 

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if ($apellido != "" && verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El apellido no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if ($telefono != "" && verificar_datos("[0-9()+ -]{7,20}", $telefono)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El teléfono no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $especialidad)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La especialidad no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

// Guardar datos

$guardar_docente = conexion();
$guardar_docente = $guardar_docente->prepare(
    "INSERT INTO docentes(usuario_id, nombre, apellido, telefono, especialidad, status)
     VALUES(:usuario_id, :nombre, :apellido, :telefono, :especialidad, 'ACTIVO')"
);

$marcadores = [
    ":usuario_id" => $usuario_id,
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":telefono" => $telefono,
    ":especialidad" => $especialidad
];

$guardar_docente->execute($marcadores);

if ($guardar_docente->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡DOCENTE REGISTRADO!</strong><br>
            El docente se ha registrado con éxito en el sistema.
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar al docente, por favor intente nuevamente.
        </div>
    ';
}

$guardar_docente = null;
?>
