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
  @if(@Auth::user()->hasAnyPermission('CRUD_catalogs','CRUD_users'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGeneralData" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-folder-open"></i>
      <span>Configuración general</span>
    </a>
    <div id="collapseGeneralData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header"> Tareas </h6>
        <a class="collapse-item" href="/gestionar-variables-del-sistema">Gestionar </a>
      </div>
    </div>
  </li>
  @endif

  {{-- Nav Item - Projects Collapse Menu--}}
  @if(@Auth::user()->hasAnyPermission('CR_projects','CRUD_projects','CR_users','CRUD_users'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGeneralProjects" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-folder-open"></i>
      <span>Proyectos</span>
    </a>
    <div id="collapseGeneralProjects" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header"> Proyectos </h6>
        <a class="collapse-item" href="/gestionador-proyectos">Gestionar</a>
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
        @if(@Auth::user()->can('CRUD_parameters'))
          <h6 class="collapse-header">Parametrización </h6>
          <a class="collapse-item" href="/gestionador-parametrizacion">Gestionar</a>
        @endif
        @if(@Auth::user()->hasAnyPermission('CRUD_macroprocess','CRUD_tasks'))
          <h6 class="collapse-header">Macroprocesos</h6>
          <a class="collapse-item" href="/gestionador-macroprocesos">Gestionar</a>
        @endif
      </div>
    </div>
  </li>
  @endif
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

  {{-- Nav Item - Users Collapse Menu--}}

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNot" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span  style="color:red;"> Ejemplos de Notificación </span>
    </a>
    <div id="collapseNot" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        {{-- <h6 class="collapse-header"> Opciones:</h6> --}}
        <a class="collapse-item" href="/notificador">Ver</a>
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
