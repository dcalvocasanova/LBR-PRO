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
        <project-nav-header></project-nav-header>
        @if(auth()->user()->can('CRUD_projects') )
          <projects :show-delete-and-update-button=1></projects>
        @else
          <projects :show-delete-and-update-button=0></projects>
        @endif
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
