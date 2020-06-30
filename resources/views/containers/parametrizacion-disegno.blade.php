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
        <h1 class="h2 mb-0 text-gray-900">Etapas de parametrización: diseño de instrumentos</h1>
      </div>
      <div class="row">
        <div class="accordion col-12" id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Diseño instrumentos para carga de trabajos
                </button>
              </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <div class="row">
                  @component('components.colorcard')
                  @slot('title') Gestionar parametrización del análisis de cargas de trabajo @endslot
                  @slot('type') success @endslot
                  @slot('subtitle') ir @endslot
                  @slot('url') gestionar-parametros @endslot
                  @slot('icon') fas fa-tags @endslot
                  @endcomponent

                  @component('components.colorcard')
                  @slot('title') Plantillas @endslot
                  @slot('type') info @endslot
                  @slot('subtitle') ir @endslot
                  @slot('url') gestionar-plantillas-parametros @endslot
                  @slot('icon') fas fa-tags @endslot
                  @endcomponent

                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Diseño de instrumentos para análisis psicosocial
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <div class="row">
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
                  @slot('title') Gestionar variables análisis psicosocial @endslot
                  @slot('type') success @endslot
                  @slot('subtitle') ir @endslot
                  @slot('url') gestionador-variables-analisis-psicosocial @endslot
                  @slot('icon') fa fa-question @endslot
                  @endcomponent

                  @component('components.colorcard')
                  @slot('title') Plantillas @endslot
                  @slot('type') info @endslot
                  @slot('subtitle') ir @endslot
                  @slot('url') gestionar-plantillas-analisis-psicosicial @endslot
                  @slot('icon') fas fa-tags @endslot
                  @endcomponent

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Adding footer --}}
  @include('layouts.footer')
</div>
@endsection
