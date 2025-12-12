<?php
    require_once "./php/main.php";

    $id=(isset($_GET['teacher_id_up'])) ? $_GET['teacher_id_up'] : 0 ;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
        <h1 class="title">Docente</h1>
	    <h2 class="subtitle">Actualizar docente</h2>
</div>

<div class="container pb-6 pt-6">
        <?php 
            include "./inc/btn_back.php";

            $check_docente=conexion();
            $check_docente=$check_docente->query("SELECT * FROM docente WHERE id='$id'");

            if($check_docente->rowCount()>0){
                $datos=$check_docente->fetch();
        ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/docente_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $datos['id']; ?>" name="id" required >

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <div class="select is-fullwidth">
                    <select name="usuario_id" required>
                        <?php
                        $conexion = conexion();
                        $usuarios = $conexion->query("SELECT id, correo FROM usuario WHERE status='ACTIVO' ORDER BY correo ASC");
                        $usuarios = $usuarios->fetchAll();

                        foreach($usuarios as $u){
                            echo '<option value="'.$u['id'].'">'.$u['correo'].'</option>';
                        }
                        ?>
                    </select>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="nombre"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="apellido"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40">
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Telefono</label>
                    <input class="input" type="text" name="telefono"
                    pattern="[0-9()+ -]{7,20}" maxlength="20">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <input class="input" type="text" name="especialidad"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
                </div>
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
            $check_docente=null;
        ?>
</div>