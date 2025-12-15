<?php
    require_once "./php/main.php";

    $id=(isset($_GET['subject_id_up'])) ? $_GET['subject_id_up'] : 0 ;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
        <h1 class="title">Materias</h1>
	    <h2 class="subtitle">Actualizar materia</h2>
</div>

<div class="container pb-6 pt-6">
        <?php 
            include "./inc/btn_back.php";

            $check_materia=conexion();
            $check_materia=$check_materia->query("SELECT * FROM materias WHERE id='$id'");

            if($check_materia->rowCount()>0){
                $datos=$check_materia->fetch();
        ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/materia_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $datos['id']; ?>" name="id" required >
		
		<div class="columns">
            <div class="column is-half">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="nombre"
                    value="<?php echo $datos['nombre']; ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,200}" maxlength="200" required>

                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Tipo</label>
                    <div class="select is-fullwidth">
                        <select name="tipo" required>
                            <option value="">Selecciona un tipo</option>
                            <option value="ESPECIALIDAD" <?php if($datos['tipo']=="ESPECIALIDAD") echo "selected"; ?>>
                                Especialidad
                            </option>
                            <option value="TRONCOCOMUN" <?php if($datos['tipo']=="TRONCOCOMUN") echo "selected"; ?>>
                                Tronco común
                            </option>
                        </select>
                    </div>
                </div>
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
            $check_materia=null;
        ?>
</div>