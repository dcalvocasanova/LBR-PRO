@extends('layouts.dashboard')
@section('content')
  {{-- Adding menu --}}
  @include('layouts.menu')
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      {{-- Adding top bar navigator --}}
      @include('layouts.topbar')
      {{-- Adding page content --}}
		
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
      <div class="container-fluid">
		<phyco-measures></phyco-measures>
      </div>
    </div>
    {{-- Adding footer --}}
    @include('layouts.footer')
  </div>
@endsection
