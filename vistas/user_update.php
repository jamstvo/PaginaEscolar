<?php
    require_once "./php/main.php";

    $id=(isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0 ;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']){ ?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php }else{ ?>
        <h1 class="title">Usuarios</h1>
	    <h2 class="subtitle">Actualizar usuario</h2>
    <?php } ?>
</div>

<div class="container pb-6 pt-6">
        <?php 
            include "./inc/btn_back.php";

            $check_usuario=conexion();
            $check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id='$id'");

            if($check_usuario->rowCount()>0){
                $datos=$check_usuario->fetch();
        ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $datos['id']; ?>" name="id" required >
		
		<div class="columns">
            <div class="column is-half">
                <label class="label">Correo</label>
                <input class="input" type="email" name="correo"
                    value="<?php echo $datos['correo']; ?>" required>
            </div>

            <div class="column is-half">
                <label class="label">Rol</label>
                <div class="select is-fullwidth">
                    <select name="rol" required>
                        <option value="admin" <?php if($datos['rol']=="admin") echo "selected"; ?>>Admin</option>
                        <option value="docente" <?php if($datos['rol']=="docente") echo "selected"; ?>>Docente</option>
                    </select>
                </div>
            </div>
        </div>

		<br><br>
        <hr>

        <p class="has-text-centered mb-4">
            Si desea actualizar la clave de este usuario, llene ambos campos.
            Si no, déjelos vacíos.
        </p>

        <div class="columns is-centered">
            <div class="column is-4">
                <label class="label">Nueva contraseña</label>
                <input class="input" type="password" name="clave_1">
            </div>

            <div class="column is-4">
                <label class="label">Repetir contraseña</label>
                <input class="input" type="password" name="clave_2">
            </div>
        </div>

		<br><br><br>
        <hr>

<p class="has-text-centered mb-4">
    Para confirmar los cambios, ingrese su correo y contraseña
    con los que ha iniciado sesión.
</p>

<div class="columns is-centered">
    <div class="column is-4">
        <label class="label">Correo</label>
        <input class="input" type="email" name="administrador_correo" required>
    </div>

    <div class="column is-4">
        <label class="label">Contraseña</label>
        <input class="input" type="password" name="administrador_clave" required>
    </div>
</div>
<div class="has-text-centered mt-5">
    <button class="button is-success is-rounded">
        Actualizar
    </button>
</div>

	</form>
        <?php 
            }else{
            include "./inc/error_alert.php";
            }
            $check_usuario=null;
        ?>
</div>