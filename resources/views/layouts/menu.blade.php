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

  {{-- Heading
  <div class="sidebar-heading">
    Panel de gestión
  </div>
--}}
  {{-- Nav Item - Projects Collapse Menu--}}
  @if(@Auth::user()->hasAnyPermission('CRUD_catalogs','CRUD_projects','CR_projects'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGeneralData" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-folder-open"></i>
      <span>Gestión del sistema</span>
    </a>
    <div id="collapseGeneralData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header"> Principales tareas </h6>
        <a class="collapse-item" href="/gestionar-actividades">Gestionar </a>
      </div>
    </div>
  </li>
  @endif
  {{-- Nav Item - Users Collapse Menu--}}
  @if(@Auth::user()->hasAnyPermission('CRUD_parameters','CRUD_macroprocess','CRUD_tasks'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParameters" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span> Parametrización</span>
    </a>
    <div id="collapseParameters" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @if(@Auth::user()->hasAnyPermission('CRUD_catalogs','CRUD_projects','CR_projects'))
          <h6 class="collapse-header">Configuración del proyecto</h6>
          <a class="collapse-item" href="/gestionar-usuarios">Usuarios</a>
          <a class="collapse-item" href="/gestionar-estructura-proyecto">Gestionar niveles</a>
          <a class="collapse-item" href="#">funciones y validaciones</a>
        @endif
        @if(@Auth::user()->can('CRUD_parameters'))
          <h6 class="collapse-header">Parametrización </h6>
          <a class="collapse-item" href="/gestionar-parametros">Parámetros</a>
          <a class="collapse-item" href="#">Tiempos de ajuste</a>
          <a class="collapse-item" href="/gestionar-plantillas-parametros">Plantillas</a>
          <a class="collapse-item" href="/gestionar-calendario">Calendario</a>
        @endif
        @if(@Auth::user()->can('CRUD_macroprocess'))
          <h6 class="collapse-header">Macroprocesos</h6>
          <a class="collapse-item" href="#">Catálogo acciones</a>
          <a class="collapse-item" href="#">Objetivos</a>
          <a class="collapse-item" href="/gestionar-macroprocesos">Macroprocesos</a>
          <a class="collapse-item" href="#">Procesos</a>
          <a class="collapse-item" href="#">Subprocesos</a>
        @endif
        @if(@Auth::user()->can('CRUD_tasks'))
          <a class="collapse-item" href="#">Tareas</a>
        @endif

      </div>
    </div>
  </li>
  @endif
  {{-- Nav Item - Users Collapse Menu--}}
  @if(@Auth::user()->hasPermissionTo('simple_user'))
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
  @endif

  {{-- Divider--}}
  <hr class="sidebar-divider">

  {{-- Sidebar Toggler (Sidebar)--}}
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
{{-- End of Sidebar--}}
