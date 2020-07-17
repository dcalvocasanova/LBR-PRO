<template>
<div id="header-project-option-navigator" class="w-100">
    <div class="row justify-content-center">
        <div class="col-4 col-xs-6">
          <div class="card border-info mx-sm-1 p-3">
            <a href="/gestionar-tareas">
              <div class="card border-info shadow text-info p-3 my-card" ><span class="fas fa-tasks" aria-hidden="true"></span></div>
              <div class="text-info text-center mt-3"><h4> </h4></div>
              <div class="text-info text-center mt-2 d-none d-md-block"><h5>Tareas</h5></div>
            </a>
          </div>
        </div>
        <div class="col-4 col-xs-6">
          <div class="card border-success mx-sm-1 p-3">
            <a href="/notificar-aprobacion-de-tareas">
              <div class="card border-success shadow text-success p-3 my-card"><span class="fas fa-project-diagram" aria-hidden="true"></span></div>
              <div class="text-info text-center mt-3"><h4> </h4></div>
              <div class="text-success text-center mt-2 d-none d-md-block"><h5>Notificaciones</h5></div>
            </a>
          </div>
        </div>
        <div class="col-4 col-xs-6">
          <div class="card border-danger mx-sm-1 p-3">
            <a href="/reporte-envio-tareas">
              <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-user" aria-hidden="true"></span></div>
              <div class="text-info text-center mt-3"><h4> </h4></div>
              <div class="text-danger text-center mt-2 d-none d-md-block"><h5>Reportes</h5></div>
            </a>
          </div>
        </div>
    </div>
 </div>
</template>
<style media="screen" scoped>
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
