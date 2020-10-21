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
            <h1 class="h2 mb-0 text-gray-900">Gestión de las tareas administrativas para configuración de los proyectos</h1>
          </div>
          <div class="row">
            @if(auth()->user()->can('CRUD_users') )
              @component('components.colorcard')
                @slot('title') Gestionar usuarios del sistema @endslot
                @slot('type') info @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-usuarios-del-sistema @endslot
                @slot('icon') fas fa-user @endslot
              @endcomponent
            @endif
            @if(auth()->user()->can('CRUD_catalogs') )
              @component('components.colorcard')
                @slot('title') Gestionar catálogos del sistema @endslot
                @slot('type') danger @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-catalogos @endslot
                @slot('icon') fas fa-boxes @endslot
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
          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
