<?php 
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=limpiar_cadena($_POST['id']);

    // Verificar la materia
    $check_materia=conexion();
    $check_materia = conexion()->prepare(
    "SELECT * FROM materias WHERE id=:id");
    $check_materia->execute([":id"=>$id]);


    if($check_materia->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                la materia no existe en el sistema.
            </div>
        ';
        exit();
    }else{
        $datos=$check_materia->fetch();
    }
    $check_materia=null;

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
    $check_admin=$check_admin->query("SELECT correo,contrasena_hash FROM usuarios WHERE 
    correo='$admin_correo' AND id='".$_SESSION['id']."'");
    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();

        if($check_admin['correo']!=$admin_correo || !password_verify($admin_clave, $check_admin
        ['contrasena_hash'])){
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
    $nombre=limpiar_cadena($_POST['nombre']);
    $tipo=limpiar_cadena($_POST['tipo']);

    // Verificando campos obligatorios
    if($nombre=="" || $tipo==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }

    // // Validar que los valores del tipo estén entre las opciones permitidas
        $tipos = ["ESPECIALIDAD","TRONCOCOMUN"];

        if (!in_array($tipo, $tipos, true)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Tipo no válido.
                </div>
            ';
            exit();
        }

    // Verificando integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El nombre no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Actualizar datos
    $actualizar_materia=conexion();
    $actualizar_materia=$actualizar_materia->prepare("UPDATE materias SET nombre=:nombre,
    tipo=:tipo  WHERE
    id=:id");

    $marcadores=[
        ":id"=>$id,
        ":nombre"=>$nombre,
        ":tipo"=>$tipo
    ];

    if($actualizar_materia->execute($marcadores)){
        echo'
            <div class="notification is-info is-light">
                <strong>¡Materia actualizado!</strong><br>
                La materia se ha actualizado con exito.
            </div>
        ';
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar la materia, por favor intente nuevamente.
            </div>
        ';
    }
    $actualizar_materia=null;
?>