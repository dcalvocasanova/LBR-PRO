{{-- Sidebar--}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
  {{-- Sidebar - Brand--}}
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fab fa-product-hunt"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Labor <sup>PRO</sup></div>
  </a>

  {{-- Divider --}}
  <hr class="sidebar-divider my-0">

  {{-- Nav Item - Dashboard--}}
  <li class="nav-item">
    <a class="nav-link" href="/home">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  {{-- Divider--}}
  <hr class="sidebar-divider">

  {{-- Heading--}}
  <div class="sidebar-heading">
    Panel de gestión
  </div>

  {{-- Nav Item - Projects Collapse Menu--}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGeneralData" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-folder-open"></i>
      <span>Datos generales del sistema</span>
    </a>
    <div id="collapseGeneralData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header"> Proyecto o Actividad:</h6>
        <a class="collapse-item" href="/gestionar-proyectos">Gestionar </a>
        <h6 class="collapse-header"> Usarios del sistema</h6>
        <a class="collapse-item" href="/gestionar-usuarios">Gestionar</a>
        <h6 class="collapse-header"> Catálogos</h6>
        <a class="collapse-item" href="/gestionar-catalogos">Gestionar</a></a>

      </div>
    </div>
  </li>

  {{-- Nav Item - Users Collapse Menu--}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParameters" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span> Parametrización</span>
    </a>
    <div id="collapseParameters" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Configuración del proyecto</h6>
        <a class="collapse-item" href="/gestionar-usuarios">Usuarios</a>
        <a class="collapse-item" href="/gestionar-estructura-proyecto">Gestionar niveles</a>
        <a class="collapse-item" href="#">funciones y validaciones</a>
        <h6 class="collapse-header">Parametrización </h6>
        <a class="collapse-item" href="/gestionar-parametros">Parámetros</a>
        <a class="collapse-item" href="#">Tiempos de ajuste</a>
        <a class="collapse-item" href="/gestionar-plantillas-parametros">Plantillas</a>
        <a class="collapse-item" href="/gestionar-calendario">Calendario</a>
        <h6 class="collapse-header">Macroprocesos</h6>
        <a class="collapse-item" href="#">Catálogo acciones</a>
        <a class="collapse-item" href="#">Objetivos</a>
        <a class="collapse-item" href="/gestionar-macroprocesos">Macroprocesos</a>
        <a class="collapse-item" href="#">Procesos</a>
        <a class="collapse-item" href="#">Subprocesos</a>
        <a class="collapse-item" href="#">Tareas</a>
        <a class="collapse-item" href="/gestionar-tree">tree</a>
      </div>
    </div>
  </li>

  {{-- Nav Item - Users Collapse Menu--}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHelp" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span  style="color:red;"> Ejemplos de ¡AYUDA! </span>
    </a>
    <div id="collapseHelp" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        {{-- <h6 class="collapse-header"> Opciones:</h6> --}}
        <a class="collapse-item" href="/ayuda">Ver</a>

      </div>
    </div>
  </li>

  {{-- Divider--}}
  <hr class="sidebar-divider">

  {{-- Sidebar Toggler (Sidebar)--}}
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
{{-- End of Sidebar--}}
