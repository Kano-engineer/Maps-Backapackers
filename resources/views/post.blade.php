<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 
<head>
    <meta charset="UTF-8">
    <title>Maps.Backpackers</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <style>
        body {
        background: url("../image/5.jpg");
        }
    </style>
</head>
 
<body>
<!-- TOD:Use app.blade.php -->
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                Maps.Backpackers
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                                
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <a class="nav-link dropdown-toggle"  href="/profile"><i class="fas fa-user"></i>My Profile</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                        <ul class="navbar-nav mr-auto">
                            <div class="sidebar">
                                <div class="sidebar-item">
                                <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                                    @if (Auth::user()->images->isEmpty()) 
                                        <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                                    @else
                                        @foreach(Auth::user()->images as $image)
                                        <img style="width:250px;height:200px;" src="{{ asset('storage/' . $image['file_name']) }}">
                                        @endforeach
                                    @endif
                                        <p><a href="/profile" class="btn btn-primary"><i class="fas fa-user"></i>My Profile</a></p>
                                    <div class="btn-sidebar">
                                        <a type="button" class="btn btn-primary btn-sm" href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a>
                                        <br>
                                        <p></p>
                                        <a type="button" class="btn btn-primary btn-sm" href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                                        <p></p>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div id="app">
                            <example-component></example-component>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <a></a>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body> 
</html>