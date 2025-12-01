<div class="container is-fluid mb-6">
    <h1 class="title">Docentes</h1>
    <h2 class="subtitle">Nuevo docente</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/docente_guardar.php" method="POST" autocomplete="off">

      <div class="columns">
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
                    <label>Email</label>
                    <input class="input" type="email" name="email" maxlength="70" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>

    </form>
</div>