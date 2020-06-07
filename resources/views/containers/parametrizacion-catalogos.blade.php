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
          <div class="accordion col-12" id="accordionExample">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Catálogos de parametrización
                  </button>
                </h2>
              </div>
              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
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
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Parametrización de objetivos
                  </button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row">
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
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Parametrización Macroprocesos, procesos, subprocesos
                  </button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row">
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
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Funciones de usuario
                  </button>
                </h2>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row">
                    @if(auth()->user()->can('CRUD_users') )
                      @component('components.colorcard')
                        @slot('title') Funciones de los usuarios @endslot
                        @slot('type') danger @endslot
                        @slot('subtitle') ir @endslot
                        @slot('url') gestionar-funciones-usuarios @endslot
                        @slot('icon') fas fa-boxes @endslot
                      @endcomponent
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingFive">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    Parametrización de tareas
                  </button>
                </h2>
              </div>
              <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="row">
                    @if(auth()->user()->can('CRUD_tasks') )
                      @component('components.colorcard')
                        @slot('title') Gestión de Tareas @endslot
                        @slot('type') info @endslot
                        @slot('subtitle') ir @endslot
                        @slot('url') gestionar-tareas @endslot
                        @slot('icon') fas fa-boxes @endslot
                      @endcomponent

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
                    @endif
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
