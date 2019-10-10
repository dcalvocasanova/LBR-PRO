<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  {{--  Favicon --}}
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon.ico') }}" />
  <link rel="icon" type="image/ico" href="{{ asset('img/favicon.ico') }}" />
  {{--  CSRF Token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Labor PRO'</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div id="app">
    <main class="labor-pro">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-12 col-md-10">
            <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="p-5">
                      <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Hola, tienes una invitación para ingresar el nuestro sistema </h1>
                      </div>
                      <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Nombre : {{$nameEmail}}</label>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{$messageEmail}}</label>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
