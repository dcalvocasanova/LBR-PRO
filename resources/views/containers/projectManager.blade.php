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

            @component('components.colorcard')
              @slot('title') Gestionar usuarios @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-usuarios @endslot
              @slot('icon') fas fa-user @endslot
            @endcomponent

            @if(auth()->user()->can('CRUD_projects') )
              @component('components.colorcard')
                @slot('title') Gestionar niveles @endslot
                @slot('type') info @endslot
                @slot('subtitle') ir @endslot
                @slot('url') gestionar-estructura-proyecto @endslot
                @slot('icon') fas fa-swatchbook @endslot
              @endcomponent
            @endif
            @if(auth()->user()->can('CRUD_users') )
              @component('components.colorcard')
                @slot('title') Validaciones y funciones @endslot
                @slot('type') danger @endslot
                @slot('subtitle') ir @endslot
                @slot('url') # @endslot
                @slot('icon') fas fa-boxes @endslot
              @endcomponent
            @endif
          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
