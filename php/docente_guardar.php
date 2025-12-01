<?php
    require_once "main.php";

    // Almacenando datos
    $nombre      = limpiar_cadena($_POST['nombre']);
    $apellido    = limpiar_cadena($_POST['apellido']);
    $telefono    = limpiar_cadena($_POST['telefono']);
    $email       = limpiar_cadena($_POST['email']);

    // Verificando campos obligatorios
    if ($nombre == "" || $apellido == "" || $telefono == "" || $email == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios.
            </div>
        ';
        exit();
    }

    // Verificando integridad de los datos
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El nombre no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El apellido no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    if (verificar_datos("[0-9()+ -]{7,20}", $telefono)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El telefono no coincide con el formato solicitado.
            </div>
        ';
        exit();
    }

    // Validación de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El correo electrónico no es válido.
            </div>
        ';
        exit();
    } else {
        $check_email = conexion();
        // Verifica email único por docente
        $check_email = $check_email->query("SELECT email FROM docente WHERE email='$email'");
        if ($check_email->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El email ingresado ya se encuentra registrado, por favor elija otro.
                </div>
            ';
            exit();
        }
        $check_email = null;
    }

    // Guardando datos (por default docente está activo)
    $guardar_docente = conexion();
    $guardar_docente = $guardar_docente->prepare("INSERT INTO docente(nombre, apellido, telefono, email, estado) VALUES(:nombre, :apellido, :telefono, :email, 'ACTIVO')");

    $marcadores = [
        ":nombre"   => $nombre,
        ":apellido" => $apellido,
        ":telefono" => $telefono,
        ":email"    => $email
    ];

    $guardar_docente->execute($marcadores);

    if ($guardar_docente->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡DOCENTE REGISTRADO!</strong><br>
                El docente se ha registrado con éxito en el sistema.
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar al docente, por favor intente nuevamente.
            </div>
        ';
    }

    $guardar_docente = null;
?>