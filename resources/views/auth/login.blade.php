@extends('layouts.dashboard')

@section('content')

<div class="wrapper wrapper-full-page">
  <div class="page-header login-page header-login" filter-color="gray" style="background-image: url('{{ asset('img/PROCAME2.jpg') }}'); ; background-size: cover; background-position: top center;">
      <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8 col-sm-9 ml-auto mr-auto">
            <form class="form" method="" action="">
              <div class="card card-login">
                <div class="card-header card-header-red-UNA text-center">
                  <h4 class="card-title">Inicio de sesión </h4>
                </div>
                <br>
                <div class="card-body ">
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user-lock"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control" placeholder="Usuario">
                    </div>
                  </span>
                  <br><br>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-key"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control" placeholder="Contraseña">
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <button class="btn btn-red-UNA btn-lg">Ingresar</button>
                  <a class="btn btn-red-UNA btn-link btn-lg" href="{{ route('password.request') }}">¡Olvidé mi contraseña!</a>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
