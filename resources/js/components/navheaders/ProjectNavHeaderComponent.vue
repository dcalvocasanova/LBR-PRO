<template>
  <div id="header-project-option-navigator" class="row w-100">
    <div class="col-md-3">
      <div class="card border-info mx-sm-1 p-3">
        <a href="/gestionar-proyectos">
          <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-tasks" aria-hidden="true"></span></div>
          <div class="text-info text-center mt-3"><h4> </h4></div>
          <div class="text-info text-center mt-2"><h3>Proyectos</h3></div>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-success mx-sm-1 p-3">
        <a href="/gestionar-estructura-proyecto">
          <div class="card border-success shadow text-success p-3 my-card"><span class="fas fa-project-diagram" aria-hidden="true"></span></div>
          <div class="text-info text-center mt-3"><h4> </h4></div>
          <div class="text-success text-center mt-2"><h3>Niveles</h3></div>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-danger mx-sm-1 p-3">
        <a href="/gestionar-usuarios">
          <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-user" aria-hidden="true"></span></div>
          <div class="text-info text-center mt-3"><h4> </h4></div>
          <div class="text-danger text-center mt-2"><h3>Usuarios</h3></div>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-danger mx-sm-1 p-3">
        <a href="/gestionar-roles-usuarios">
          <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fas fa-users-cog" aria-hidden="true"></span></div>
          <div class="text-info text-center mt-3"><h4> </h4></div>
          <div class="text-danger text-center mt-2"><h3>Roles</h3></div>
        </a>
      </div>
    </div>
 </div>
</template>


<style media="screen">

#header-project-option-navigator{
  margin-bottom: 50px;
}

.my-card
{
    position:absolute;
    left:40%;
    top:-20px;
    border-radius:65%;
}
</style>
