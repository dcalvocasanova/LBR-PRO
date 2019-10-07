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
                  <h4 class="card-title"> Cambio de contraseña</h4>
                </div>
                <br>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"> Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"> Nueva contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"> Confirmar nueva contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-red-UNA btn-lg">
                                    Cambiar contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
