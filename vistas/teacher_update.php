<?php
    require_once "./php/main.php";

    $id=(isset($_GET['teacher_id_up'])) ? $_GET['teacher_id_up'] : 0 ;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']){ ?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php }else{ ?>
        <h1 class="title">Docente</h1>
	    <h2 class="subtitle">Actualizar docente</h2>
    <?php } ?>
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
					<label>Nombres</label>
				  	<input class="input" type="text" name="nombre" value="<?php echo $datos['nombre']; ?>" 
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" name="apellido" value="<?php echo $datos['apellido']; ?>" 
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Telefono</label>
				  	<input class="input" type="text" name="telefono" value="<?php echo $datos['telefono']; ?>"
                    pattern="[0-9()+ -]{7,20}" maxlength="20" required>
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="email" value="<?php echo $datos['correo']; ?>" 
                    maxlength="70" >
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este docente por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="administrador_usuario" 
                    pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="administrador_clave" 
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
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