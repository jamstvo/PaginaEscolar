<?php
    // Almacenar datos
    $correo=limpiar_cadena($_POST['login_correo']);
    $clave=limpiar_cadena($_POST['login_clave']);

    // Verificar campos obligatorios
    if($correo=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }
    
    // Verificar integridad de los datos
        if(verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,50}", $correo)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El correo no coincide con el formato solicitado.
                </div>
            ';
            exit();
        }

        if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)){
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
    $check_user = $check_user->query("SELECT * FROM usuario WHERE correo='$correo'");
    if($check_user->rowCount() == 1){
        $check_user = $check_user->fetch();

        if($check_user['correo'] == $correo && password_verify($clave, $check_user['contraseña_hash'])){
            $_SESSION['id'] = $check_user['id'];
            $_SESSION['correo'] = $check_user['correo'];
            $_SESSION['rol'] = $check_user['rol'];

           
                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=home'; </script>";
                }else{
                    header("Location: index.php?vista=home");
                }
           
            
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Correo o contraseña incorrectos.
                </div>
            ';
            exit();
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Correo o contraseña incorrectos.
            </div>
        ';
        exit();
    }
    $check_user = null;
?>