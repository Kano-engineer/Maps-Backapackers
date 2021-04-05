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
                            
                            <a class="nav-link dropdown-toggle"  href="/profile"><i class="fas"></i>My Profile</a>

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
                <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                   <!-- User's image -->
                   @if ($user_images->isEmpty()) 
                        <img style="" src="{{ URL::asset('image/profile.png') }}" />
                    @else
                        @foreach ($user_images as $user_image)
                            <img style="border-radius: 50%;" src="{{ asset('storage/' . $user_image['file_name']) }}">
                            <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                @if(Auth::user()->id === $user->id)
                                    <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                @endif
                            </form>
                        @endforeach
                    @endif
                    <div>
                    @if ($errors->has('file'))
                        @foreach($errors->all() as $error)
                        <font color =red>*{{ $error }}</font>
                        @endforeach
                    @endif
                    </div>
                    <!-- Upload image -->
                    @if(Auth::user()->id === $user->id)

                        @if($user_images->count())
                            <table border="1">
                            </table>
                        @else
                            <form action="/profile/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="photo"></label>
                                <input type="file" class="form-control" name="file"accept='image/*' onchange="previewImage(this);">
                                <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
                                    <br>
                                    <br>
                                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
                            </form>
                        @endif

                    @endif

                    <div class="card-body">
                        <br>
                        <!-- <h5><i class="fas fa-user">{{ $user->name }}</i></h5> -->
                        <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ $user->name }}</h5>
                        <!-- Following / Followers -->
                        <div class="d-flex flex-row" style="display:flex;justify-content: center;">
                                <div class="p-2">
                                    <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->follows()->count() }} Following</i></a>
                                </div>
                                <div class="p-2">
                                <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->followUsers()->count() }} Followers</i></a>
                                </div>
                        </div>
                        <!-- Profile comment -->
                        <div>
                            @if ($errors->has('comment_profile'))
                                @foreach($errors->all() as $error)
                                <font color =red>*{{ $error }}</font>
                                @endforeach
                            @endif
                        </div>
                        @if(Auth::user()->id === $user->id)
                            <form action="/profile/comment/{{ $user->id }}" method="post">
                                {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <input name="comment_profile" type="text" class="form-control" placeholder="自己紹介をどうぞ" >
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        @foreach ($comments as $comment)
                            <div class="d-flex flex-row" >
                                <div class="p-2">
                                    <p class="card-text" style="color:#094067;white-space: pre-wrap;">{{ $comment ->comment}}</p>   
                                </div>
                                <div class="p-2">
                                    @if(Auth::user()->id === $user->id)
                                        <form action="{{ action('ProfileController@destroyComment', $comment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Follow button:Display only in other users' profiles  -->
                        @if(Auth::user()->id !== $user->id)
                            @if($user->followUsers()->where('following_user_id', Auth::id())->exists())
                                <form action="{{ route('unfollow', $user) }}" method="POST" style="display: flex;justify-content: flex-end;margin-right: 8px;margin-top: 16px;">
                                    @csrf
                                    <input type="submit" value="&#xf164; Following" class='fas btn btn-primary'>
                                </form>
                                @else
                                <form action="{{ route('follow', $user) }}" method="POST" style="display: flex;justify-content: flex-end;margin-right: 8px;margin-top: 16px;">
                                    @csrf
                                    <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                </form>
                            @endif
                        @endif
                    </div>
                    <!-- class="card-body" -->
                    <!-- Following / Followers -->
                    <div class="d-flex flex-row">
                            <div class="p-2">
                                <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->follows()->count() }} Following</i></a>
                            </div>
                            <div class="p-2">
                            <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->followUsers()->count() }} Followers</i></a>
                            </div>
                    </div>
                </div>
                <!-- class="card" -->
                <p></p>
            </div>
            <div class="col-md-9">
                <!-- Update:Use tab menu for switching between list and likes -->
                <div class="tab_container" style="
    box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);
">
                <input id="tab1" type="radio" name="tab_item" checked>
                <label class="tab_item" for="tab1"><i class="fas fa-globe-europe"></i> MAP：{{ $pins->count() }}</label>
                <input id="tab2" type="radio" name="tab_item">
                <label class="tab_item" for="tab2"><i class="fas fa-list"></i> LIST：{{ $pin->count() }}</label>
                <input id="tab3" type="radio" name="tab_item">
                <label class="tab_item" for="tab3"><i class="far fa-thumbs-up"></i> LIKES：{{ $user->favorites->count() }}</label>
                    <!-- TAB1:MAP -->
                    <div class="tab_content" id="tab1_content">
                        <div class="tab_content_description">
                            <!-- Form -->
                            <!-- <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                            <br>
                            <br> -->
                                @if($pins->count())
                                    <table border="1">
                                        <!-- Show map -->
                                        <div class="map_wrapper">
                                            <div id="gmap" class="gmap" style="overflow: hidden;height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"></div>
                                        </div>
                                        <div style="display: flex;justify-content: flex-end;"><a type="button" href="/form" class="btn btn-primary" style="margin-top: 16px;width: 50%;/* padding: 0px; */font-size: 30px;/* box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); */border-radius: 20px;"><i class="fas fa-edit">Share Your Travel</i></a></div>
                                    </table>
                                @else
                                    <div style="display: flex;justify-content: flex-end;"><a type="button" href="/form" class="btn btn-primary" style="margin-top: 16px;width: 50%;/* padding: 0px; */font-size: 30px;/* box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); */border-radius: 20px;"><i class="fas fa-edit">Share Your Travel</i></a></div>
                                @endif
                        </div>
                    </div>

                    <!-- TAB:LIST -->
                    <div class="tab_content" id="tab2_content">
                        <div class="tab_content_description">
                            <!-- Form -->
                            <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                            <br>
                            <br>
                            <!-- LIST -->
                            @foreach ($pin as $pin)
                            <div class="card">
                                <h5 class="card-header" style="color:#094067;">
                                    <div class="d-flex flex-row">
                                        <div class="p-2">
                                            @if ($pin->user->images->isEmpty())
                                                <a href="/profile/{{$pin->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                            @else
                                                @foreach($pin->user->images as $image)
                                                <a href="/profile/{{$pin->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas">{{$pin->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pin->text }}</i>
                                        </div>
                                        <div class="p-2">
                                            <!-- Follow button:Display only in other users' profiles  -->
                                            @if(Auth::user()->id !== $pin->user->id)
                                                @if($pin->user->followUsers()->where('following_user_id', Auth::id())->exists())
                                                    <form action="{{ route('unfollow', $pin->user) }}" method="POST">
                                                        @csrf
                                                        <a></a><input type="submit" value="&#xf164; Following" class='fas btn btn-primary'></a>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('follow', $pin->user) }}" method="POST">
                                                        @csrf
                                                        <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </h5>
                                <a href="/post/{{$pin->id}}" class="card-body" style="text-decoration: none;">
                                    <p class="card-text" style="color:black;">{{ $pin->created_at}}</p>
                                    <p class="card-text" style="color:black;">{{ $pin->body}}</p>
                                    <!-- @if ($pin->photos->isEmpty()) 
                                            <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                                    @else -->
                                            @foreach($pin->photos as $photo)
                                            <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                            @endforeach
                                    <!-- @endif -->
                                        <p class="card-text"></p>
                                    @if($pin->users()->where('user_id', Auth::id())->exists())
                                        <form action="{{ route('unfavorites', $pin) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-primary">
                                        </form>
                                    @else
                                        <form action="{{ route('favorites', $pin) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-link">
                                        </form>
                                    @endif
                                </a>
                            </div>
                                <br>
                            @endforeach
                        </div>
                    </div>
                        
                    <!-- TAB:LIKES -->
                    <div class="tab_content" id="tab3_content">
                        <div class="tab_content_description">
                            <!-- Form -->
                            <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                            <br>
                            <br>
                            <!-- LIKES -->
                            @foreach ($user->favorites->reverse() as $favorite)
                            <div class="card">
                                <h5 class="card-header" style="color:#094067;">
                                    <div class="d-flex flex-row">
                                    <div class="p-2">
                                        @if ($favorite->user->images->isEmpty()) 
                                            <a href="/profile/{{$favorite->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                        @else
                                            @foreach($favorite->user->images as $image)
                                            <a href="/profile/{{$favorite->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="p-2">
                                        <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$favorite->user_id}}"><i class="fas">{{$favorite->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $favorite->text }}</i>
                                    </div>
                                    
                                    <div class="p-2">
                                    <!-- Follow button:Display only in other users' profiles  -->
                                    @if(Auth::user()->id !== $favorite->user->id)
                                        @if($favorite->user->followUsers()->where('following_user_id', Auth::id())->exists())
                                            <form action="{{ route('unfollow', $favorite->user) }}" method="POST">
                                                @csrf
                                                <a></a><input type="submit" value="&#xf164; Following" class='fas btn btn-primary'></a>
                                            </form>
                                            @else
                                            <form action="{{ route('follow', $favorite->user) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                            </form>
                                        @endif
                                    @endif
                                    </div>
                                    </div>
                                </h5>
                                <a href="/post/{{$favorite->id}}" class="card-body" style="text-decoration: none;">
                                    <p class="card-text" style="color:black;">{{ $favorite->created_at}}</p>
                                    <p class="card-text" style="color:black;">{{ $favorite->body}}</p>
                                    <!-- @if ($favorite->photos->isEmpty()) 
                                            <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                                    @else -->
                                            @foreach($favorite->photos as $photo)
                                            <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                            @endforeach
                                    <!-- @endif -->
                                        <p class="card-text"></p>
                                    @if($favorite->users()->where('user_id', Auth::id())->exists())
                                        <form action="{{ route('unfavorites', $favorite) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164; LIKE！ {{ $favorite->users()->count() }}" class="fas btn btn-primary">
                                        </form>
                                    @else
                                        <form action="{{ route('favorites', $favorite) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164; LIKE！ {{ $favorite->users()->count() }}" class="fas btn btn-link">
                                        </form>
                                    @endif
                                </a>
                            </div>
                            <br>
                            @endforeach
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

function previewImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function() {
		document.getElementById('preview').src = fileReader.result;
	});
	fileReader.readAsDataURL(obj.files[0]);
}

function initMap() {
    
    // Laravelからpins -> text:「住所」が入った 配列を addresses 渡す。
    var addresses = [];
    const pin = @json($pins);
    for(let i in pin) {
    addresses.push(pin[i].location);
    }
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
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('/js/alert.js') }}"></script>
</body>
</html>
