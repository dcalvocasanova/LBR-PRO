<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-{{$type}} shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-{{$type}} text-uppercase mb-1">{{ $title }}</div>
          <button class="btn btn-{{$type}}">
            <a href="{{ $url }}">
              <div class="h5 mb-0 font-weight-bold" style="color:white">{{ $subtitle }}</div>              
            </a>
          </button>
        </div>
        <div class="col-auto">
            <i class="{{ $icon }} fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>
