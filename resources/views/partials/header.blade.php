<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Tag -->
    <title>@yield('title') | Laravel Vue Boilerplate</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{mix('/css/front-all.css')}}">

    <!-- Custom Styles -->
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ url('/') }}"><strong>{{ config('app.name', 'LVB') }}</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lvb_navbar"
            aria-controls="lvb_navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="lvb_navbar">
        <ul class="navbar-nav mr-auto"></ul>
        <ul class="navbar-nav">
            <li class="nav-item "><a href="{{ url('/') }}" class="nav-link text-white">Home</a></li>
            @if (Route::has('login'))
                @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-white">Login</a></li>
                    @if (Route::has('register'))
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link text-white">Register</a>
                        </li>
                    @endif
                @endguest
            @endif
            @auth
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{Auth::user()->gravatar_url}}" class="img-thumbnail rounded-circle" width="30"
                             alt="{{Auth::user()->name}}"> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endauth
        </ul>
    </div>
</nav>
