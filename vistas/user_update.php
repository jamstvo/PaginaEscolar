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
            $check_usuario=$check_usuario->query("SELECT * FROM usuario WHERE id='$id'");

            if($check_usuario->rowCount()>0){
                $datos=$check_usuario->fetch();
        ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $datos['id']; ?>" name="id" required >
		
		<div class="columns">
            <div class="column is-half">
                <div class="control">
                    <label>Correo</label>
                    <input class="input" type="email" name="email" maxlength="70" required>
                </div>
            </div>
        </div>

            <div class="column">
                <div class="control">
                    <label>Rol</label>
                    <div class="select is-fullwidth">
                        <select name="rol" required>
                            <option value="">Selecciona un rol</option>
                            <option value="admin">admin</option>
                            <option value="docente">docente</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
            <div class="column">
                <div class="control">
                    <label>Contraseña</label>
                    <input class="input" type="password" name="clave_1"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Repetir contraseña</label>
                    <input class="input" type="password" name="clave_2"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su CORREO y CONTRASEÑA
             con la que ha iniciado sesións
		</p>
		<div class="field">
            <label class="label">Correo</label>
            <div class="control">
                <input class="input" type="email" name="administrador_correo" 
                maxlength="255" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
                <input class="input" type="password" name="administrador_clave" 
                pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
        <?php 
            }else{
            include "./inc/error_alert.php";
            }
            $check_usuario=null;
        ?>
</div>