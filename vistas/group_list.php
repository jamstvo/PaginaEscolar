<div class="container is-fluid mb-6">
    <h1 class="title">Grupos</h1>
    <h2 class="subtitle">Lista de grupos</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        require_once "./php/main.php";
        
        // Eliminar grupo
        if(isset($_GET['group_id_del'])){
            require_once "./php/grupo_status.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=group_list&page=";
        $registros=3;
        $busqueda="";
        $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'ACTIVO';

        ?>
        <form method="GET" class="mb-4">
        <input type="hidden" name="vista" value="group_list">
        <input type="hidden" name="page" value="<?php echo $pagina; ?>">

        <div class="field">
            <label class="label">Mostrar:</label>
            <div class="control">
                <div class="select">
                    <select name="status_filter" onchange="this.form.submit()">
                        <option value="ACTIVO" <?php if($status_filter == 'ACTIVO') echo 'selected'; ?>>Activos</option>
                        <option value="EGRESADO" <?php if($status_filter == 'EGRESADO') echo 'selected'; ?>>Egresados</option>
                        <option value="TODOS" <?php if($status_filter == 'TODOS') echo 'selected'; ?>>Todos</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <?php

        require_once "./php/grupo_lista.php";
    ?>
</div>