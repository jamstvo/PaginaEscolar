<?php
    require_once "main.php";

    // Almacenando datos
    $usuario=limpiar_cadena($_POST['usuario']);

    $nombre=limpiar_cadena($_POST['nombre']);
    $apellido=limpiar_cadena($_POST['apellido']);

    $telefono=limpiar_cadena($_POST['telefono']);
    $email=limpiar_cadena($_POST['email']);

    $clave_1=limpiar_cadena($_POST['clave_1']);
    $clave_2=limpiar_cadena($_POST['clave_2']);

    // Verificando campos obligatorios
    if($usuario=="" || $nombre=="" || $email=="" || $clave_1=="" || $clave_2==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }

    // Verificando integridad de los datos
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El nombre no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El apellido no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[0-9()+ -]{7,20}",$telefono)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El telefono no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    
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

    // Verificando el email
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El correo electrónico no es válido.
            </div>
        ';
        exit();
    }else{
        $check_email=conexion();
        $check_email=$check_email->query("SELECT email FROM usuario WHERE email='$email'");
        if($check_email->rowCount()>0){
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El email ingresado ya se encuentra registrado, por favor elija otro.
                </div>
            ';
            exit();
        }
        $check_email=null;
    }

    // Verificando usuario
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT usuario FROM usuario WHERE usuario='$usuario'");
    if($check_usuario->rowCount()>0){
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario ingresado ya se encuentra registrado, por favor elija otro.
            </div>
        ';
        exit();
    }
    $check_usuario=null;

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
    $guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuario(usuario, nombre, apellido, 
    telefono, email, password, creado_el)
    VALUES(:usuario, :nombre, :apellido, :telefono, :email, :password, NOW())
    ");

    $marcadores=[
        ":usuario"=>$usuario,
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":telefono"=>$telefono,
        ":email"=>$email,
        ":password"=>$clave,
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