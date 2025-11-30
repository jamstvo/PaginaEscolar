<?php
    $teacher_id_del=limpiar_cadena($_GET['teacher_id_del']);

    // Verificando docente
    $check_docente=conexion();
    $check_docente=$check_docente->query("SELECT id FROM docente WHERE id='$docente_id_del'");
    if($check_docente->rowCount()==1){
        $eliminar_docente=conexion();
        $eliminar_docente=$eliminar_docente->prepare("DELETE FROM docente WHERE id=:id");

        $eliminar_docente->execute([":id" => $user_id_del]);

        if($eliminar_usuario->rowCount()==1){
            echo'
                <div class="notification is-info is-light">
                    <strong>¡Usuario eliminado!</strong><br>
                    Los datos del usuario se eliminaron con exito.
                </div>
            ';
        }else{
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el usuario, por favor intente nuevamente
                </div>
            ';
        }
        $eliminar_usuario=null;
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario que intenta eliminar no existe.
            </div>
        ';
    }
    $check_usuario=null;
?>