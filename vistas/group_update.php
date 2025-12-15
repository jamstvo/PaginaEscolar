<?php
require_once "./php/main.php";

if (!isset($_GET['group_id_up']) || $_GET['group_id_up'] == "") {
    echo '<div class="notification is-danger is-light">ID de grupo no válido.</div>';
    exit();
}

$grupo_id = limpiar_cadena($_GET['group_id_up']);

$conexion = conexion();

/* Obtener datos del grupo */
$grupo = $conexion->query("
    SELECT * FROM grupos 
    WHERE id='$grupo_id'
")->fetch();

if (!$grupo) {
    echo '<div class="notification is-danger is-light">Grupo no encontrado.</div>';
    exit();
}

/* Obtener docentes activos */
$docentes = $conexion->query("
    SELECT id, nombre, apellido 
    FROM docentes 
    WHERE status='ACTIVO'
    ORDER BY nombre ASC
");


?>

<div class="container is-fluid mb-6">
    <h1 class="title">Grupo</h1>
    <h2 class="subtitle">Actualizar grupo</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/grupo_actualizar.php" method="POST" autocomplete="off">

        <input type="hidden" name="grupo_id" value="<?= $grupo['id'] ?>">

        <div class="columns">

            <div class="column">
                <div class="control">
                    <label>Nombre del grupo</label>
                    <input class="input" type="text" name="nombre"
                        value="<?= $grupo['nombre'] ?>"
                        pattern="[A-Z0-9]{1,2}" maxlength="2" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Semestre</label>
                    <input class="input" type="number" name="semestre"
                        min="1" max="6"
                        value="<?= $grupo['semestre'] ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <div class="select is-fullwidth">
                        <select name="especialidad" required>
                            <?php
                            $especialidades = [
                                "Contabilidad","Electricidad","Mantenimiento Automotriz",
                                "Programacion","Ofimatica","Laboratorista Quimico"
                            ];
                            foreach ($especialidades as $esp) {
                                $selected = ($grupo['especialidad'] == $esp) ? "selected" : "";
                                echo "<option value=\"$esp\" $selected>$esp</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="columns">

            <div class="column">
                <div class="control">
                    <label>Generación</label>
                    <input class="input" type="text" name="generacion"
                        value="<?= $grupo['generacion'] ?>"
                        pattern="[0-9\-]{9}" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Año de inicio</label>
                    <input class="input" type="number" name="anio_inicio"
                        min="2000" max="2100"
                        value="<?= $grupo['anio_inicio'] ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Tutor del grupo</label>
                    <div class="select is-fullwidth">
                        <select name="tutor_id">
                            <option value="">Sin tutor</option>
                            <?php
                            foreach ($docentes as $d) {
                                $selected = ($grupo['tutor_id'] == $d['id']) ? "selected" : "";
                                echo '
                                    <option value="'.$d['id'].'" '.$selected.'>
                                        '.$d['nombre'].' '.$d['apellido'].'
                                    </option>
                                ';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="columns">
            <div class="column has-text-centered">
                <button type="submit" class="button is-info is-rounded">
                    Actualizar
                </button>
            </div>
        </div>

    </form>

</div>
