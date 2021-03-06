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
            <h1 class="h2 mb-0 text-gray-900"> Análisis de los instrumentos</h1>
          </div>
          <div class="row">
            @component('components.colorcard')
              @slot('title') Gestionar elementos asociados a tareas @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-tareas-variables-adicionales @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent

			      @component('components.colorcard')
              @slot('title') Gestionar plantillas @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') /gestionar-plantillas-usuarios @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent		     

          </div>
		   <div class="row">
          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
