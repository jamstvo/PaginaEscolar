<div class="container is-fluid mb-6">
    <h1 class="title">Materias</h1>
    <h2 class="subtitle">Nueva materia</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/materia_guardar.php" method="POST" autocomplete="off">

        <div class="columns">
            <div class="column is-half">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="nombre"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,200}" maxlength="200" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Tipo</label>
                    <div class="select is-fullwidth">
                        <select name="tipo" required>
                            <option value="">Selecciona un tipo</option>
                            <option value="ESPECIALIDAD">Especialidad</option>
                            <option value="TRONCOCOMUN">Tronco común</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>

    </form>
</div>