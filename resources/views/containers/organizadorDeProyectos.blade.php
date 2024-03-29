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
            <h1 class="h2 mb-0 text-gray-900">Gestión de usuarios, niveles y ajustes de los proyectos</h1>
          </div>
          <div class="row">

          @if(auth()->user()->can('CRUD_projects') || auth()->user()->can('CR_projects'))
            @component('components.colorcard')
              @slot('title') Gestionar proyectos @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-proyectos @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent
          @endif

            @if(auth()->user()->can('CRUD_projects'))
              @component('components.colorcard')
                @slot('title') Gestionar niveles @endslot
                @slot('type') info @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-estructura-proyecto @endslot
                @slot('icon') fas fa-swatchbook @endslot
              @endcomponent
            @endif

            @if(auth()->user()->can('CRUD_users') || auth()->user()->can('CR_users'))
              @component('components.colorcard')
                @slot('title') Gestionar usuarios @endslot
                @slot('type') success @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-usuarios @endslot
                @slot('icon') fas fa-user @endslot
              @endcomponent
              @component('components.colorcard')
                @slot('title') Gestionar roles de los usuarios @endslot
                @slot('type') success @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-roles-usuarios @endslot
                @slot('icon') fas fa-user @endslot
              @endcomponent
            @endif

            @component('components.colorcard')
              @slot('title') Gestionar ajustes de medición del proyecto @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') ajustes-medicion @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent

          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
