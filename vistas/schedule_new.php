<?php
require_once "./php/main.php";
?>

<div class="container is-fluid mb-6">
    <h1 class="title">Horarios</h1>
    <h2 class="subtitle">Nueva clase</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/horario_guardar.php" method="POST" autocomplete="off">

        <div class="columns">

            <!-- Grupo -->
            <div class="column">
                <div class="control">
                    <label>Grupo</label>
                    <div class="select is-fullwidth">
                        <select name="id_grupo" required>
                            <option value="">Seleccione un grupo</option>
                            <?php
                                $conexion = conexion();
                                $grupos = $conexion->query(
                                    "SELECT id, semestre, especialidad, generacion 
                                     FROM grupos 
                                     WHERE status='ACTIVO' 
                                     ORDER BY semestre ASC"
                                );
                                foreach ($grupos as $g) {
                                    echo '<option value="'.$g['id'].'">'.
                                        'Sem '.$g['semestre'].' - '.$g['especialidad'].' ('.$g['generacion'].')'.
                                        '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Docente -->
            <div class="column">
                <div class="control">
                    <label>Docente</label>
                    <div class="select is-fullwidth">
                        <select name="id_docente" required>
                            <option value="">Seleccione un docente</option>
                            <?php
                                $docentes = $conexion->query(
                                    "SELECT id, nombre, apellido 
                                     FROM docentes
                                     WHERE status='ACTIVO' 
                                     ORDER BY nombre ASC"
                                );
                                foreach ($docentes as $d) {
                                    echo '<option value="'.$d['id'].'">'.
                                        $d['nombre'].' '.$d['apellido'].
                                        '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="columns">

            <!-- Materia -->
            <div class="column">
                <div class="control">
                    <label>Materia</label>
                    <div class="select is-fullwidth">
                        <select name="id_materia" required>
                            <option value="">Seleccione una materia</option>
                            <?php
                                $materias = $conexion->query(
                                    "SELECT id, nombre 
                                     FROM materias 
                                     ORDER BY nombre ASC"
                                );
                                foreach ($materias as $m) {
                                    echo '<option value="'.$m['id'].'">'.$m['nombre'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Día -->
            <div class="column">
                <div class="control">
                    <label>Día</label>
                    <div class="select is-fullwidth">
                        <select name="dia" required>
                            <option value="">Seleccione un día</option>
                            <option>LUNES</option>
                            <option>MARTES</option>
                            <option>MIERCOLES</option>
                            <option>JUEVES</option>
                            <option>VIERNES</option>
                            <option>SABADO</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="columns">

            <div class="column">
    <div class="control">
        <label>Hora inicio (clase dura 50 min)</label>
        <input class="input" type="time" name="hora_inicio"
               min="07:00" max="13:20" required>
        <p class="help">
            Horario permitido: 07:00 – 14:10<br>
            Recesos: 09:30–09:50 y 11:30–11:40
        </p>
    </div>
</div>


        </div>

        <div class="columns">
            <div class="column has-text-centered">
                <button type="submit" class="button is-primary is-rounded">
                    Guardar clase
                </button>
            </div>
        </div>

    </form>
</div>
