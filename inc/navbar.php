<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
        <img src="./img/DGETI.jpg" width="60" height="100">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Docentes</a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=teacher_new">Nuevo</a>
            <a class="navbar-item" href="index.php?vista=teacher_list">Lista</a>
            <a class="navbar-item" href="index.php?vista=teacher_search">Buscar</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Grupos</a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=group_new">Nuevo</a>
            <a class="navbar-item" href="index.php?vista=group_list">Lista</a>
            <a class="navbar-item" href="index.php?vista=group_search">Buscar</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Horarios</a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=schedule_new">Nueva clase</a>
            <a class="navbar-item" href="index.php?vista=schedule_list">Ver</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Materias</a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=subject_new">Nuevo</a>
          <a class="navbar-item" href="index.php?vista=subject_list">Lista</a>
          <a class="navbar-item" href="index.php?vista=subject_search">Buscar</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Usuarios</a>
        <div class="navbar-dropdown">
            <a class="navbar-item" href="index.php?vista=user_new">Nuevo</a>
            <a class="navbar-item" href="index.php?vista=user_list">Lista</a>
            <a class="navbar-item" href="index.php?vista=user_search">Buscar</a>
        </div>
    </div>

  </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" 
          class="button is-primary is-rounded">
            Mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-link is-rounded">
            Salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
