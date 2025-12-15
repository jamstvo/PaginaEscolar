<?php
require_once "./php/main.php";

$mes_actual = date("n");
$ciclo = ($mes_actual <= 6) ? "par" : "impar";
?>

<div class="container is-fluid mb-6">
    <h1 class="title">Grupo</h1>
    <h2 class="subtitle">Nuevo grupo</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/grupo_guardar.php" method="POST" autocomplete="off">

        <div class="columns">

            <div class="column">
                <div class="control">
                    <label>Nombre del grupo</label>
                    <input class="input" type="text" name="nombre"
                    pattern="[A-Z0-9]{1,2}" maxlength="2" required>
                </div>
            </div>
            
            <div class="column">
                <div class="control">
                    <label>Semestre</label>
                    <div class="select is-fullwidth">
                        <select name="semestre" id="semestre" required></select>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <div class="select is-fullwidth">
                        <select name="especialidad" required>
                            <option value="">Seleccione especialidad</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Electricidad">Electricidad</option>
                            <option value="Mantenimiento Automotriz">Mantenimiento Automotriz</option>
                            <option value="Programacion">Programación</option>
                            <option value="Ofimatica">Ofimática</option>
                            <option value="Laboratorista Quimico">Laboratorista Químico</option>
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
                    pattern="[0-9\-]{9}" placeholder="2024-2027" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Año de inicio</label>
                    <input class="input" type="number" name="anio_inicio"
                    min="2000" max="2100" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Tutor del grupo</label>
                    <div class="select is-fullwidth">
                        <select name="tutor_id" required>
                            <?php
                                $conexion = conexion();
                                $docentes = $conexion->query(
                                    "SELECT id, nombre, apellido FROM docentes WHERE status='ACTIVO' ORDER BY nombre ASC"
                                );
                                $docentes_count = ($docentes) ? $docentes->rowCount() : 0;
                            ?>
                            <option value=""><?php echo ($docentes_count == 0) ? 'No hay tutores disponibles' : 'Seleccione un tutor'; ?></option>
                            <?php
                                if ($docentes_count > 0) {
                                    foreach ($docentes as $d) {
                                        echo '<option value="'.htmlspecialchars($d['id']).'">'.
                                            htmlspecialchars($d['nombre'].' '.$d['apellido']).
                                            '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>


        </div>
        <div class="columns">
            <div class="column has-text-centered">
                <button type="submit" class="button is-primary is-rounded">
                    Guardar
                </button>
            </div>
        </div>

    </form>

    <script>
        window.CICLO_ACTUAL = "<?= $ciclo ?>";
    </script>

    <script src="./js/semestres.js"></script>


</div>