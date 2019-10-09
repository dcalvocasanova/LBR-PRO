@extends('layouts.base')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-10">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Inicio de sesión</h1>
                  </div>
                  <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¡Olvidé mi contraseña!
                                </a>
                            @endif
                        </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



{{--
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
 Fonts --}}

@endsection
