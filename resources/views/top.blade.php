<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JIKOKEN_SAN') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts&styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat+Subrayada" rel="stylesheet">
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>


<div class="main-logo">JIKOKEN SAN</div>

<div class="main-text">
    <p class="main-dear">強くなるための努力を惜しまないあなたへ。</p>
    <p>JIKOKENさんと可視化してみませんか？日々の努力を客観視すれば、強くなるための近道が見えるかも。</p>
</div>
<div class="top-chart">
        <div class="content">
            <span class="circle circle-target"><i class="fas fa-flag big-icon"></i>
                <p class="out-circle target"><span class="txt-bold">目標</span>を設定して駆け抜けよう</p>
            </span>
            <span class="circle circle-task"><i class="fas fa-tasks big-icon"></i></i>
                <p class="out-circle task">タスク管理で<span class="txt-bold">効率</span>UPを目指そう</p>
            </span>
            <span class="circle circle-diary"><i class="fas fa-file-alt big-icon"></i>
                <p class="out-circle diary">一行日記で続ける<span class="txt-bold">習慣</span>を作ろう</p>
            </span>
            <span class="circle circle-friend"><i class="fas fa-users big-icon"></i>
                <p class="out-circle friend"><span class="txt-bold">仲間</span>と高め合おう</p>
            </span>
        </div>
</div>


    <div class="linkbox-nav">
         <!-- Authentication Links -->
            @guest
                <p><a class="nav-link top-to-nav" href="{{ route('login') }}">{{ __('Login') }}</a></p>
                @if (Route::has('register'))
                    <p><a class="nav-link top-to-nav" href="{{ route('register') }}">{{ __('Register') }}</a></p>
                @endif
                @else
                    <a id="navbarDropdown" class="nav-link dropdown-toggle top-to-nav" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}</a>
                    <div class="dropdown-menu top-to-nav" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
         @endguest
    </div>

<div class="container">
    <div class="row justify-content-center">
            <div class="main-copy col-md-8">
                    <blockquote cite="">
                        <p class="fadein f-title">自己研鑽【じこけんさん】</p>
                        <p class="fadein f-txt">自分自身のスキルや能力などを鍛えて磨きをかけること。
                        <p class="fadein quotation-JIKOKEN">実用日本語表現辞典</p></p>
                    </blockquote>
            </div>
    </div>
    <div class="out-container">
        <p>"研鑽"という言葉には<span class="txt-bold">学問などを深く究めること</span>という意味があります。<br>
        自己研鑽を怠らないためには、明確な目的意識を持ち かつ長期的に継続することが大切です。<br>
        「目指すべきものは何か・その先で何ができるのか」を忘れてはいけません。<br>
        JIKOKENさんが 目標設定、TODOリスト作成、一行日記の継続をサポートします。<br>
        また、自己研鑽を積む仲間の刺激的な姿もあなたを強くするのに必要なものとなるでしょう。</p>
    </div>
</div>


@include('common.footer')
</body>
</html>