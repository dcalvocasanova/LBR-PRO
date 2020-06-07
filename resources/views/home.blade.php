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
          <div class="col-6">
            <project-picker></project-picker>
          </div>
        </div>
        <div class="row">
          HOME PAGE, HERE YOU WILL FIND SOME BEAUTIFULL CHARTS AND MORE STATICS
        </div>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
