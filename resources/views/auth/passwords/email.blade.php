@extends('layouts.dashboard')

@section('content')


    <div class="container mt-4" >
      <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8 col-sm-9 ml-auto mr-auto">
            <form class="form" method="" action="">
              <div class="card card-login">
                <div class="card-header card-header-red-UNA text-center">
                  <h4 class="card-title"> Cambio de contraseña</h4>
                </div>
                <br>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                          <div class="col-md-6">
                            <span class="bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="fas fa-user-lock"></i>
                                  </span>
                                </div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                            </span>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    Enviar
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


@endsection
