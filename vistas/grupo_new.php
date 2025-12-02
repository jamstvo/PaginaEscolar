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
                    <label>Semestre</label>
                    <div class="select is-fullwidth">
                        <select name="semestre" required>
                            <option value="">Seleccione semestre</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <div class="select is-fullwidth">
                        <select name="especialidad">
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
    </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>

    </form>
</div>