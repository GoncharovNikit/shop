<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="red" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.css" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
    <div id="before-load">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
<input type="text" name="root" id="root" value="{{ $_SERVER['DOCUMENT_ROOT'] }}" hidden>
    @include('layouts.partials.header')
    <!-- / header -->

    <!-- / navigation -->


    @yield('content')


    @include('layouts.partials.footer')
    <!-- / footer -->


    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        window.jQuery || document.write("<script src='{{asset('js/jquery-1.11.1.min.js')}}'>\x3C/script>")
    </script>
    <script src="{{asset('js/plugins.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.js"></script>
    <script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>