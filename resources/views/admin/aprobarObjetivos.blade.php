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
        <notificator-project-structure
          :show-as-structure-editor=false
          :show-as-goal-editor=false
          :just-show-tree=true
        >
      </notificator-project-structure>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
