@extends('layouts.dashboard')
@section('content')
  {{-- Adding menu --}}
  @include('layouts.menu')
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      {{-- Adding top bar navigator --}}
      @include('layouts.topbar')
      {{-- Adding page content --}}
      <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h2 mb-0 text-gray-900">Gestión para configurar catálogos de parametrización</h1>
          </div>
          <div class="row">
            @if(auth()->user()->can('CRUD_macroprocess') )
              @component('components.colorcard')
                @slot('title') Catálogo de acciones para registro de condiciones de trabajo @endslot
                @slot('type') success @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-catalogos-macroprocesos @endslot
                @slot('icon') fas fa-tags @endslot
              @endcomponent
            @endif
            @if(auth()->user()->can('CRUD_tasks') )
              @component('components.colorcard')
                @slot('title') Catálogo de acciones para registro de tareas @endslot
                @slot('type') success @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-catalogos-tareas @endslot
                @slot('icon') fas fa-tags @endslot
              @endcomponent
            @endif

            @component('components.colorcard')
              @slot('title') Gestionar objetivos de los niveles @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-objetivos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Notificar aprobación de objetivos @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') notificar-aprobacion-de-objetivos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Reporte de aprobación de objetivos @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') reporte-envio-objetivos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Gestionar Funciones de Usuarios @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-funciones-usuarios @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Registrar macroprocesos  @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-macros @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Ficha del  macroprocesos @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-macroprocesos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent	          

            @component('components.colorcard')
              @slot('title') Registrar procesos @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-procesos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') SubProcesos @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-subprocesos @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @if(auth()->user()->can('CRUD_users') )
              @component('components.colorcard')
                @slot('title') Funciones de los usuarios @endslot
                @slot('type') danger @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-funciones-usuarios @endslot
                @slot('icon') fas fa-boxes @endslot
              @endcomponent
            @endif

            @if(auth()->user()->can('CRUD_tasks') )
              @component('components.colorcard')
                @slot('title') Gestión de Tareas @endslot
                @slot('type') info @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-tareas @endslot
                @slot('icon') fas fa-boxes @endslot
              @endcomponent
            @endif
            @component('components.colorcard')
              @slot('title') Notificar aprobación de tareas @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') notificar-aprobacion-de-tareas @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Reporte de aprobación de tareas @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') reporte-envio-tareas @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

        </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
