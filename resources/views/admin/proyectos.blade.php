@extends('layouts.dashboard')
@section('content')
  {{-- Adding menu --}}
  @component('layouts.menu')
  @endcomponent
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      {{-- Adding top bar navigator --}}
      @component('layouts.topbar')
      @endcomponent
      {{-- Adding page content --}}
      <div class="container-fluid">
        <projects></projects>
      </div>
    </div>
    {{-- Adding footer --}}
    @component('layouts.footer')
    @endcomponent
  </div>
@endsection
