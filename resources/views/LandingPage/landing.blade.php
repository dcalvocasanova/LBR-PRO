@extends('layouts.dashboard')

@section('content')



<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">


    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->


    </div>
    <!-- /.container-fluid -->
    <div class="container-fluid">


                        <form method="POST" action="{{ route('loginForm') }}">
                            {{ csrf_field() }}

                            <div class="field form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="field-label">Correo</label>

                                <input id="email" title="Ingrese el correo electrónico de usuario registrado en el sistema INTEGRA." type="email" class="form-control field-input"
                                    name="email" value="{{ old('email') }}" required autofocus>                                @if ($errors->has('email'))
                                <span class="help-block">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span> @endif
                            </div>

                            <div class="field form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="field-label">Contrase&ntilde;a</label>

                                <input id="password" title="Presione este botón una vez que haya ingresado el usuario y la contrase&ntilde;a" type="password" class="form-control field-input"
                                    name="password" required> @if ($errors->has('password'))
                                <span class="help-block">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span> @endif
                            </div>

                            <div class="form-group{{ $errors->has('locked') ? ' has-error' : '' }}">
                                <button type="submit" class="btn btn-success pull-right">Ingresar</button> @if ($errors->has('locked'))
                                <span class="help-block">
                                                                    <strong>{{ $errors->first('locked') }}</strong>
                                                                </span> @endif
                            </div>
                        </form>




    </div>
  @component('layouts.footer')
  @endcomponent

  </div>
</div>

@endsection
