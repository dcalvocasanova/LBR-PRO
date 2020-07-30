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

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <h5 class="card-header">
                Seleccionar proyecto
              </h5>
              <div class="card-body">
                <p class="card-text col-12">

                  <project-picker></project-picker>
                </p>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6 text-center mt-4 mb-1">
                <project-time></project-time>
              </div>
              <div class="col-md-6 text-center mt-1 mb-1 ">
                <project-date></project-date>
              </div>
            </div>
          </div>
        </div>

        <div class="row m-3 mt-5">
          @component('components.colorcard')
            @slot('title') Rellenar medición del día @endslot
            @slot('type') success @endslot
            @slot('subtitle') ir @endslot
            @slot('url') gestionar-tareas-con-variables-medicion @endslot
            @slot('icon') fas fa-tags @endslot
          @endcomponent
        </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
