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
            <h1 class="h2 mb-0 text-gray-900">Estapa de parametrización: diseño de instrumentos</h1>
          </div>
          <div class="row">
            @component('components.colorcard')
              @slot('title') Gestionar parametrización del análisis de cargas de trabajo @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-parametros @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Gestionar parametrización del análisis psicosocial @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') /gestionador-parametros-analisis-psicosocial @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Gestionar criterios de evaluación @endslot
              @slot('type') success @endslot
              @slot('subtitle') ir @endslot
              @slot('url') parametrizar-criterios-evaluacion @endslot
              @slot('icon') fa fa-question @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Gestionar validaciones @endslot
              @slot('type') danger @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-calendario @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Tiempos de ajuste @endslot
              @slot('type') warning  @endslot
              @slot('subtitle') ir @endslot
              @slot('url') parametrizar-tiempos-ajuste @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Plantillas @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-plantillas-parametros @endslot
              @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Tareas y frecuencias @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-tareas @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent

            @component('components.colorcard')
              @slot('title') Tareas y variables asociadas @endslot
              @slot('type') info @endslot
              @slot('subtitle') ir @endslot
              @slot('url') gestionar-tareas-con-variables-asociadas @endslot
              @slot('icon') fas fa-boxes @endslot
            @endcomponent
          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
