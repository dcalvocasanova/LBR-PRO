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
            <h1 class="h2 mb-0 text-gray-900">Reportes de medición de las cargas de trabajo </h1>
          </div>
          <div class="row">
            @component('components.colorcard')
            @slot('title') Reporte de frecuencias @endslot
            @slot('type') success @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/frecuencias @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de PHVA @endslot
            @slot('type') success @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/phva @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Competecias de Trabajo  @endslot
            @slot('type') success @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/competencias @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte del Esfuerzo de trabajo  @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/esfuerzo @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Tipos de Trabajo  @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/tipo-trabajo @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Riesgos de trabajo @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/riesgo @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte del Valor Agregado  @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/valor-agregado @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Correlación @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/correlacion @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Relación entre Instrumentos @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/instrumentos @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte ABC @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/abc @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Medición de Cargas de Trabajo @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/carga-trabajo @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

            @component('components.colorcard')
            @slot('title') Reporte de Cálculo de Eficiencia y Tiempos de trabajo  @endslot
            @slot('type') info @endslot
            @slot('subtitle') ir @endslot
            @slot('url') reporte/ajuste-tiempos @endslot
            @slot('icon') fas fa-tags @endslot
            @endcomponent

          </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
