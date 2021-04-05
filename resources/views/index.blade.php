<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maps.Backpackers</title>
    <meta charset="utf-8">
    <style>
    /* Map Responsive */
    .map_wrapper {
      position: relative; 
      width:100%;
      padding-top:56.25%;
      border: 1px solid #CCC;  
    }
    .map_wrapper .gmap {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    } 

    /*Tab Menu*/
    .tab_container {
        padding-bottom: 1em;
        background-color: #fff;
        border:1px solid #3490dc;
        margin: 0 auto;}
        .tab_item {
        width: calc(100%/3);
        padding:15px 0;
        border-bottom: 3px solid #3490dc ;
        background-color: #ececec;
        text-align: center;
        color: #3490dc ;
        display: block;
        float: left;
        text-align: center;
        font-weight: bold;
        transition: all 0.2s ease;
        }
        .tab_item:hover {
        opacity: 0.75;
        }
        input[name="tab_item"] {
        display: none;
        }
        .tab_content {
        display: none;
        padding: 1em 1em 0;
        clear: both;
        overflow: hidden;
        }
        #tab1:checked ~ #tab1_content,
        #tab2:checked ~ #tab2_content,
        #tab3:checked ~ #tab3_content {
        display: block;
        }
        .tab_container input:checked + .tab_item {
        background-color: #3490dc ;
        color: #fff;
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
            Maps.Backpackers
                <!-- {{ config('app.name', 'Laravel') }} -->
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
            <div class="col-md-3">
                <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                    <!-- 2/28 Update:sidebar in card -->
                        <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);
">
                            @if (Auth::user()->images->isEmpty()) 
                                <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                            @else
                                @foreach(Auth::user()->images as $image)
                                <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                @endforeach
                            @endif
                                <p></p>
                                <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user"> {{ Auth::user()->name }}</i></a>
                                <!-- <p></p>
                                <a href="/post/" type="button" class="btn btn-primary"><i class="fas fa-comment-dots"></i>TALK</a> -->
                                <p></p>
                                <a href="/index/" type="button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</a>
                        </div>
                        <p></p>
                    </div>
            </div>
            <div class="col-md-9">
                <!-- Update:Use tab menu for switching between list and likes -->
                <div class="tab_container" style="
    box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);
">
                <input id="tab1" type="radio" name="tab_item" checked>
                <label class="tab_item" for="tab1"><i class="fas fa-globe-europe"></i> MAP</label>
                <input id="tab2" type="radio" name="tab_item">
                <label class="tab_item" for="tab2"><i class="fas fa-stream"></i> TIMELINE</label>
                <input id="tab3" type="radio" name="tab_item">
                <label class="tab_item" for="tab3"><i class="far fa-user"></i> USER</label>
                    
                    <!-- TAB1:MAP -->
                    <div class="tab_content" id="tab1_content">
                        <div class="tab_content_description">
                            <!-- Form -->
                            <div class="d-flex flex-row">
                            <div class="p-2">
                                    @if ($errors->has('keyword'))
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <font color =red>*{{ $error }}</font>
                                        @endforeach
                                        </ul>
                                    @endif
                                    <form action="{{url('/books')}}" method="GET">
                                        <input type="text" name="keyword" value="">
                                        <input type="submit" value="検索">
                                    </form>
                            </div>
                            <div class="p-2">
                                    @if ($errors->has('keyword2'))
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <font color =red>*{{ $error }}</font>
                                        @endforeach
                                        </ul>
                                    @endif
                                    <form action="{{url('/books')}}" method="GET">
                                    <select name="keyword2">
                                    <option value="" selected>都道府県</option>
                                    <option value="北海道">北海道</option>
                                    <option value="青森県">青森県</option>
                                    <option value="岩手県">岩手県</option>
                                    <option value="宮城県">宮城県</option>
                                    <option value="秋田県">秋田県</option>
                                    <option value="山形県">山形県</option>
                                    <option value="福島県">福島県</option>
                                    <option value="茨城県">茨城県</option>
                                    <option value="栃木県">栃木県</option>
                                    <option value="群馬県">群馬県</option>
                                    <option value="埼玉県">埼玉県</option>
                                    <option value="千葉県">千葉県</option>
                                    <option value="東京都">東京都</option>
                                    <option value="神奈川県">神奈川県</option>
                                    <option value="新潟県">新潟県</option>
                                    <option value="富山県">富山県</option>
                                    <option value="石川県">石川県</option>
                                    <option value="福井県">福井県</option>
                                    <option value="山梨県">山梨県</option>
                                    <option value="長野県">長野県</option>
                                    <option value="岐阜県">岐阜県</option>
                                    <option value="静岡県">静岡県</option>
                                    <option value="愛知県">愛知県</option>
                                    <option value="三重県">三重県</option>
                                    <option value="滋賀県">滋賀県</option>
                                    <option value="京都府">京都府</option>
                                    <option value="大阪府">大阪府</option>
                                    <option value="兵庫県">兵庫県</option>
                                    <option value="奈良県">奈良県</option>
                                    <option value="和歌山県">和歌山県</option>
                                    <option value="鳥取県">鳥取県</option>
                                    <option value="島根県">島根県</option>
                                    <option value="岡山県">岡山県</option>
                                    <option value="広島県">広島県</option>
                                    <option value="山口県">山口県</option>
                                    <option value="徳島県">徳島県</option>
                                    <option value="香川県">香川県</option>
                                    <option value="愛媛県">愛媛県</option>
                                    <option value="高知県">高知県</option>
                                    <option value="福岡県">福岡県</option>
                                    <option value="佐賀県">佐賀県</option>
                                    <option value="長崎県">長崎県</option>
                                    <option value="熊本県">熊本県</option>
                                    <option value="大分県">大分県</option>
                                    <option value="宮崎県">宮崎県</option>
                                    <option value="鹿児島県">鹿児島県</option>
                                    <option value="沖縄県">沖縄県</option>
                                    </select>
                                    <p><input type="submit" value="県名検索"></p>
                                    </form>
                            </div>
                            </div>
                                <!-- Show map -->
                                <!-- <div class="map_wrapper">
                                    <div id="gmap" class="gmap"></div>
                                </div> -->
                        </div>
                    </div>

                    <!-- TAB:LIST -->
                    <div class="tab_content" id="tab2_content">
                        <div class="tab_content_description">
                            <!-- LIST -->
                            
                        </div>
                    </div>
                        
                    <!-- TAB:USER -->
                    <div class="tab_content" id="tab3_content">
                        <div class="tab_content_description">
                        </div>
                    </div>
                    <!-- TAB:LIKES」 -->
                </div>
                <!-- tab_container」-->
            </div>
            <!-- class="col-md-9"」 -->
        </div>
    </div>
    <!-- class="container" -->

</main>

<script>
function initMap() {
    
    // Laravelからpins -> text:「住所」が入った 配列を addresses 渡す。

    var latlng = []; //緯度経度の値をセット
    var marker = []; //マーカーの位置情報をセット
    var myLatLng; //地図の中心点をセット用
    var geocoder;
    geocoder = new google.maps.Geocoder();
    
    var map = new google.maps.Map(document.getElementById('gmap'));//地図を作成する

    geo(aftergeo);
    
    function geo(callback){
        var cRef = addresses.length;
        for (var i = 0; i < addresses.length; i++) {
            (function (i) { 
                geocoder.geocode({'address': addresses[i]}, 
                    function(results, status) { // 結果
                        if (status === google.maps.GeocoderStatus.OK) { // ステータスがOKの場合
                            latlng[i]=results[0].geometry.location;// マーカーを立てる位置をセット
                            marker[i] = new google.maps.Marker({
                                position: results[0].geometry.location, // マーカーを立てる位置を指定
                                map: map // マーカーを立てる地図を指定
                            });

                            var infoWindow = new google.maps.InfoWindow({
                            position: results[0].geometry.location, 
                            content:  `<a href='/post/${ pin[i].id }'>${ pin[i].text }</a>`, //pins->body を吹き出しに表示させ pins->idをパラメーターに使い詳細ページに遷移。
                            })
                            infoWindow.open(map);

                        } else { // 失敗した場合
                        }//if文の終了。ifは文なので;はいらない
                        if (--cRef <= 0) {
                            callback();//全て取得できたらaftergeo実行
                        }
                    }//function(results, status)の終了
                );//geocoder.geocodeの終了
            }) (i);
        }//for文の終了
    }//function geo終了

    function aftergeo(){
        myLatLng = latlng[0];//最初の住所を地図の中心点に設定
        var TokyoTower = {lat: 35.658584, lng: 139.7454316};  
        var opt = {
            center: TokyoTower, // 地図の中心を指定
            zoom: 4 // 地図のズームを指定
        };//地図作成のオプションのうちcenterとzoomは必須
        map.setOptions(opt);//オプションをmapにセット
    }//function aftergeo終了

};//function initMap終了
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>

</body>
</html>