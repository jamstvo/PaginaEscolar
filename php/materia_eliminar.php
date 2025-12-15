<?php
    $subject_id_del=limpiar_cadena($_GET['subject_id_del']);

    // Verificando materia
    $check_materia=conexion();
    $check_materia=$check_materia->query("SELECT id FROM materias WHERE id='$subject_id_del'");
    if($check_materia->rowCount()==1){
        $eliminar_materia=conexion();
        $eliminar_materia=$eliminar_materia->prepare("DELETE FROM materias WHERE id=:id");

        $eliminar_materia->execute([":id" => $subject_id_del]);

        if($eliminar_materia->rowCount()==1){
            echo'
                <div class="notification is-info is-light">
                    <strong>¡Materia eliminado!</strong><br>
                    Los datos de la materia se eliminaron con exito.
                </div>
            ';
        }else{
            echo'
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar la materia, por favor intente nuevamente
                </div>
            ';
        }
        $eliminar_materia=null;
    }else{
        echo'
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La materia que intenta eliminar no existe.
            </div>
        ';
    }
    $check_materia=null;
?>