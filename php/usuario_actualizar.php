<?php 
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=limpiar_cadena($_POST['id']);

    // Verificar el usuario
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id='$id'");

    if($check_usuario->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe en el sistema.
            </div>
        ';
        exit();
    }else{
        $datos=$check_usuario->fetch();
    }
    $check_usuario=null;

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
    $correo=limpiar_cadena($_POST['correo']);
    $rol=limpiar_cadena($_POST['rol']);
    $clave_1=limpiar_cadena($_POST['clave_1']);
    $clave_2=limpiar_cadena($_POST['clave_2']);

    // Verificando campos obligatorios
    if($correo=="" || $rol=="" || $clave_1=="" || $clave_2==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }

    // Validar que los valores de rol estén entre las opciones permitidas
        $roles = ["admin","docente"];

        if (!in_array($rol, $roles, true)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Rol no válido.
                </div>
            ';
            exit();
        }

    // Verificando integridad de los datos
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || 
       verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las claves no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Verificando el correo
    if(!filter_var($correo,FILTER_VALIDATE_EMAIL)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El correo electrónico no es válido.
            </div>
        ';
        exit();
    }else{
        $check_email=conexion();
        $check_email=$check_email->query("SELECT correo FROM usuarios WHERE correo='$correo'");
        if($check_email->rowCount()>0){
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El correo ingresado ya se encuentra registrado, por favor elija otro.
                </div>
            ';
            exit();
        }
        $check_email=null;
    }

    // Verificando claves
    if($clave_1!=$clave_2){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las contraseñas que ha ingresado no coinciden.
            </div>
        ';
        exit();
    }else{
        $clave=password_hash($clave_1,PASSWORD_BCRYPT,array("cost"=>10));
    }

    // Actualizar datos
    $actualizar_usuario=conexion();
    $actualizar_usuario=$actualizar_usuario->prepare("UPDATE usuarios SET correo=:correo,
    contrasena_hash=:contraseña,rol=:rol  WHERE
    id=:id");

    $marcadores=[
        ":id"=>$id,
        ":correo"=>$correo,
        ":contraseña"=>$clave,
        ":rol"=>$rol
    ];

    if($actualizar_usuario->execute($marcadores)){
        echo'
            <div class="notification is-info is-light">
                <strong>¡Usuario actualizado!</strong><br>
                El usuario se ha actualizado con exito.
            </div>
        ';
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el usuario, por favor intente nuevamente.
            </div>
        ';
    }
    $actualizar_usuario=null;
?>