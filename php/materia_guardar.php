<?php
    require_once "main.php";

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

    // Validar que los valores del tipo estén entre las opciones permitidas
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

    // Guardando datos
    $guardar_materia=conexion();
    $guardar_materia=$guardar_materia->prepare("INSERT INTO materias(nombre, tipo)
    VALUES(:nombre, :tipo)
    ");

    $marcadores=[
        ":nombre"=>$nombre,
        ":tipo"=>$tipo
    ];
    $guardar_materia->execute($marcadores);

    if($guardar_materia->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO REGISTRADO!</strong><br>
                La materia se ha registrado con éxito en el sistema.
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la materia, por favor intente nuevamente.
            </div>
        ';
    }

    $guardar_materia=null;
?>