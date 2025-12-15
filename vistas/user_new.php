<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Nuevo usuario</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form class="FormularioAjax" action="./php/usuario_guardar.php" method="POST" autocomplete="off">

        <div class="columns">
            <div class="column is-half">
                <div class="control">
                    <label>Correo</label>
                    <input class="input" type="email" name="correo" maxlength="70" required>
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

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Contraseña</label>
                    <input class="input" type="password" name="clave_1"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>

            <div class="column">
                <div class="control">
                    <label>Repetir contraseña</label>
                    <input class="input" type="password" name="clave_2"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>

    </form>
</div>