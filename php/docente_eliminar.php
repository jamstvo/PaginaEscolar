<?php
    $docente_id_del=limpiar_cadena($_GET['docente_id_del']);

    // Verificando docente
    $check_docente=conexion();
    $check_docente=$check_docente->query("SELECT id FROM docente WHERE id='$docente_id_del'");
    if($check_docente->rowCount()==1){
        
        $actualizar_docente=conexion();
        $actualizar_docente=$actualizar_docente->prepare("UPDATE docente SET estado='INACTIVO' WHERE id=:id");

        $actualizar_docente->execute([":id" => $docente_id_del]);

        if($actualizar_docente->rowCount()==1){
            echo'
                <div class="notification is-info is-light">
                    <strong>Docente actualizado!</strong><br>
                    El docente fue marcado como INACTIVO.
                </div>
            ';
        }else{
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo actualizar el docente, intente nuevamente.
                </div>
            ';
        }
        $actualizar_docente=null;
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El docente que intenta eliminar no existe.
            </div>
        ';
    }
    $check_docente=null;
?>