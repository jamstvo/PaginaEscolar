<?php 
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=limpiar_cadena($_POST['id']);

    // Verificar el docente
    $check_docente=conexion();
    $check_docente=$check_docente->query("SELECT * FROM docente WHERE id='$id'");

    if($check_docente->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El docente no existe en el sistema.
            </div>
        ';
        exit();
    }else{
        $datos=$check_docente->fetch();
    }
    $check_docente=null;

    $admin_correo=limpiar_cadena($_POST['administrador_correo']);
    $admin_clave=limpiar_cadena($_POST['administrador_clave']);

    // Verificando campos obligatorios
    if($admin_correo=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios, que corresponen a su CORREO 
                y CONTRASEÑA.
            </div>
        ';
        exit();
    }

    // Verificando integridad de los datos
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su contraseña no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Validar correo
        if (!filter_var($admin_correo, FILTER_VALIDATE_EMAIL)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Su correo no coincide con el formato solicitado.
                </div>
            ';
            exit();
        }

    // Verificando admin
    $check_admin=conexion();
    $check_admin=$check_admin->query("SELECT correo,contraseña_hash FROM usuario WHERE 
    correo='$admin_correo' AND id='".$_SESSION['id']."'");
    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();

        if($check_admin['correo']!=$admin_correo || !password_verify($admin_clave, $check_admin
        ['contraseña_hash'])){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Correo o contraseña de administrador incorrectos.
                </div>
            ';
            exit();
        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Correo o contraseña de administrador incorrectos.
            </div>
        ';
        exit();
    }
    $check_admin=null;

    // Almacenando datos
    $usuario_id   = limpiar_cadena($_POST['usuario_id']);
    $nombre       = limpiar_cadena($_POST['nombre']);
    $apellido     = limpiar_cadena($_POST['apellido']);
    $telefono     = limpiar_cadena($_POST['telefono']);
    $especialidad = limpiar_cadena($_POST['especialidad']);

    // Verificar campos obligatorios
if ($usuario_id == "" || $nombre == "" || $apellido == "" || $telefono == "" || $especialidad == "") {
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
$check_usuario = $check_usuario->query("SELECT id FROM usuario WHERE id = '$usuario_id' LIMIT 1");

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
$check_docente = $check_docente->query("SELECT usuario_id FROM docente WHERE usuario_id = '$usuario_id' LIMIT 1");

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

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El apellido no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[0-9()+ -]{7,20}", $telefono)) {
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

    // Actualizar datos
    $actualizar_docente=conexion();
    $actualizar_docente=$actualizar_docente->prepare("UPDATE docente SET usuario_id=:usuario_id,
    nombre=:nombre,apellido=:apellido,telefono=:telefono,especialidad=:especialidad WHERE
    id=:id");

    $marcadores=[
    ":usuario_id" => $usuario_id,
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":telefono" => $telefono,
    ":especialidad" => $especialidad
    ];

    if($actualizar_docente->execute($marcadores)){
        echo'
            <div class="notification is-info is-light">
                <strong>Docente actualizado!</strong><br>
                El docente se ha actualizado con exito.
            </div>
        ';
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar al docente, por favor intente nuevamente.
            </div>
        ';
    }
    $actualizar_docente=null;
?>