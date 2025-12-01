<?php
    // Almacenar datos
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);

    // Verificar campos obligatorios
    if($usuario=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }
    
    // Verificar integridad de los datos
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La contraseña no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Verificando usuario en la base de datos
    $check_user = conexion();
    $check_user = $check_user->query("SELECT * FROM usuario WHERE usuario='$usuario'");
    if($check_user->rowCount() == 1){
        $check_user = $check_user->fetch();

        if($check_user['usuario'] == $usuario && password_verify($clave, $check_user['password'])){
            $_SESSION['id'] = $check_user['id'];
            $_SESSION['usuario'] = $check_user['usuario'];
            $_SESSION['nombre'] = $check_user['nombre'];
            $_SESSION['apellido'] = $check_user['apellido'];
            $_SESSION['rol'] = $check_user['rol']; // <--- AGREGADO

            // Redireccion según el rol
            if($check_user['rol'] == "admin"){
                // Panel Administrador
                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=admin_dashboard'; </script>";
                }else{
                    header("Location: index.php?vista=admin_dashboard");
                }
            }elseif($check_user['rol'] == "docente"){
                // Panel Docente
                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=teacher_dashboard'; </script>";
                }else{
                    header("Location: index.php?vista=teacher_dashboard");
                }
            }else{
                // Panel Usuario Genérico
                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=usuario_consultas'; </script>";
                }else{
                    header("Location: index.php?vista=usuario_consultas");
                }
            }
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Usuario o contraseña incorrectos.
                </div>
            ';
            exit();
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o contraseña incorrectos.
            </div>
        ';
        exit();
    }
    $check_user = null;
?>