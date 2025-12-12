<?php
require_once "main.php";

$docente_id = limpiar_cadena($_GET['id']);

// Verificar que exista
$check = conexion();
$check = $check->query("SELECT usuario_id, status FROM docentes WHERE id='$docente_id' LIMIT 1");

if($check->rowCount() <= 0){
    echo '
        <div class="notification is-danger is-light">
            <strong>Error</strong><br>
            El docente no existe.
        </div>
    ';
    exit();
}

$data = $check->fetch();

$usuario_id = $data['usuario_id'];
$estado_actual = $data['status'];

$check = null;

// Nuevo estado
$nuevo_estado = ($estado_actual == "ACTIVO") ? "INACTIVO" : "ACTIVO";

// Actualizar DOCENTE
$update_docente = conexion();
$update_docente = $update_docente->prepare(
    "UPDATE docentes SET status=:status WHERE id=:id"
);
$update_docente->execute([
    ":status" => $nuevo_estado,
    ":id" => $docente_id
]);

$update_docente = null;

// Actualizar USUARIO asociado
$update_usuario = conexion();
$update_usuario = $update_usuario->prepare(
    "UPDATE usuarios SET status=:status WHERE id=:id"
);
$update_usuario->execute([
    ":status" => $nuevo_estado,
    ":id" => $usuario_id
]);

$update_usuario = null;

// Resultado
echo '
    <div class="notification is-info is-light">
        <strong>¡Estado actualizado!</strong><br>
        El docente y su usuario ahora están: <strong>'.$nuevo_estado.'</strong>
    </div>
';

echo "<script> setTimeout(()=>{ window.location.href='index.php?vista=teacher_list'; }, 1500); </script>";
