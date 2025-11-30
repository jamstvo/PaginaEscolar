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

    $admin_usuario=limpiar_cadena($_POST['administrador_usuario']);
    $admin_clave=limpiar_cadena($_POST['administrador_clave']);

    // Verificando campos obligatorios
    if($admin_usuario=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios, que corresponen a su USUARIO 
                y CLAVE.
            </div>
        ';
        exit();
    }

    // Verificando integridad de los datos
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su usuario no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su clave no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Verificando admin
    $check_admin=conexion();
    $check_admin=$check_admin->query("SELECT usuario,password FROM usuario WHERE 
    usuario='$admin_usuario' AND id='".$_SESSION['id']."'");
    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();

        if($check_admin['usuario']!=$admin_usuario || !password_verify($admin_clave, $check_admin
        ['password'])){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario o clave de administrador incorrectos.
                </div>
            ';
            exit();
        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave de administrador incorrectos.
            </div>
        ';
        exit();
    }
    $check_admin=null;

    // Almacenando datos
    $nombre=limpiar_cadena($_POST['nombre']);
    $apellido=limpiar_cadena($_POST['apellido']);

    $telefono=limpiar_cadena($_POST['telefono']);
    $email=limpiar_cadena($_POST['email']);

    // Verificando campos obligatorios
    if($nombre=="" || $apellido=="" || $telefono==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }

    // Verificando integridad de los datos
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

    // Verificando el email
    if($email!="" && $email!=$datos['email']){
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
            $check_email=$check_email->query("SELECT email FROM docente WHERE email='$email'");
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
    }

    // Actualizar datos
    $actualizar_docente=conexion();
    $actualizar_docente=$actualizar_docente->prepare("UPDATE docente SET 
    nombre=:nombre,apellido=:apellido,email=:email,telefono=:telefono WHERE
    id=:id");

    $marcadores=[
        ":id"=>$id,
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":telefono"=>$telefono,
        ":email"=>$email
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