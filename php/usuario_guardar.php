<?php
    require_once "main.php";

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

    // Guardando datos
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuarios(correo, contraseña_hash, rol, status)
    VALUES(:correo, :contraseña, :rol, 'ACTIVO')
    ");

    $marcadores=[
        ":correo"=>$correo,
        ":contraseña"=>$clave,
        ":rol"=>$rol
    ];
    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO REGISTRADO!</strong><br>
                El usuario se ha registrado con éxito en el sistema.
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el usuario, por favor intente nuevamente.
            </div>
        ';
    }

    $guardar_usuario=null;
?>