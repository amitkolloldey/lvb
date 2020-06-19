<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Tag -->
    <title>Admin | Laravel Vue Boilerplate</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
</head>
<body>

<div class="content">
    <div id="app">
        {{-- Laravel Vue Boilerplate App --}}
        <lvb-app></lvb-app>
    </div>
</div>

<!-- Scripts -->
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
