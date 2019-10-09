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
  <title>{{ config('app.name', 'Labor PRO') }}</title>
  {{--  Fonts --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
  {{--  Styles --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body class="bg-gradient-primary">
  <div id="app">
    <main class="labor-pro">
      @yield('content')
    </main>
  </div>
</body>
{{--  Scripts --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/ui.min.js') }}"></script>
</html>
