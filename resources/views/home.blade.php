@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
            <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%)">
                    @if (Auth::user()->images->isEmpty()) 
                        <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                    @else
                        @foreach(Auth::user()->images as $image)
                        <a href="/profile"><img style="border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                        @endforeach
                    @endif
                    <br>
                    <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ $user->name }}</h5>
                        <!-- <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user"> {{ Auth::user()->name }}</i></a>
                        <p></p> -->
                        <!-- <a href="/post/" type="button" class="btn btn-primary"><i class="fas fa-comment-dots"></i>TALK</a>
                        <p></p> -->
                        <a style="margin-right:8px;margin-left:8px;" href="/index/" type="button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</a>
                        <br>
                </div>
                <p></p>
            </div>
        </div>

        <div class="col-md-9">
                    <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                <input id="tab1" type="radio" name="tab_item" checked>
                <label class="tab_item" for="tab1"><i class="fas fa-globe-europe"></i> MAP</label>
                <input id="tab2" type="radio" name="tab_item">
                    <label class="tab_item" for="tab2"><i class="fas fa-stream"></i> TIMELINE</label>
                    <!-- TAB:TIMELINE -->
                    <div class="tab_content" id="tab1_content">
                        <div class="tab_content_description">
                            @if($pins->count())
                                <table border="1">
                                    <!-- Show map -->
                                    <div class="map_wrapper">
                                        <div id="gmap" class="gmap" style="overflow: hidden;height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"></div>
                                    </div>
                                    <div style="display: flex;justify-content: flex-end;"><a type="button" href="/form" class="btn btn-primary" style="margin-top: 16px;width: 50%;/* padding: 0px; */font-size: 30px;/* box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); */border-radius: 20px;"><i class="fas fa-edit">Share Your Travel</i></a></div>
                                </table>
                            @else
                                <div style="display: flex;justify-content: flex-end;"><a type="button" href="/form" class="btn btn-primary" style="margin-top: 16px;width: 50%;/* padding-top: 0px; */font-size: 30px;/* box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); */border-radius: 20px;"><i class="fas fa-edit">Share Your Travel</i></a></div>
                            @endif
                        </div>
                    </div>
                    <div class="tab_content" id="tab2_content">
                        <div class="tab_content_description">
                            <!-- Form -->
                            <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                            <br>
                            <br>
                        @foreach ($pins as $pins)
                    <div class="card">
                        <h5 class="card-header" style="color:#094067;">
                            <div class="d-flex flex-row">
                                <div class="p-2">
                                    @if ($pins->user->images->isEmpty()) 
                                        <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                    @else
                                        @foreach($pins->user->images as $image)
                                        <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2">
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pins->user_id}}"><i class="fas">{{$pins->user->name}}</i></a><i class="fas fa-map-marker-alt"> {{ $pins->text }}</i>
                                </div>
                                <div class="p-2">
                                    <!-- Follow button:Display only in other users' profiles  -->
                                    @if(Auth::user()->id !== $pins->user->id)
                                        @if($pins->user->followUsers()->where('following_user_id', Auth::id())->exists())
                                            <form action="{{ route('unfollow', $pins->user) }}" method="POST">
                                                @csrf
                                                <a></a><input type="submit" value="&#xf164; Following" class='fas btn btn-primary'></a>
                                            </form>
                                            @else
                                            <form action="{{ route('follow', $pins->user) }}" method="POST">
                                                @csrf
                                                <input style="text-decoration: none;" type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </h5>
                        <a href="/post/{{$pins->id}}" class="card-body" style="text-decoration: none;">
                            <p class="card-text" style="color:black;">{{ $pins->created_at}}</p>
                            <p class="card-text" style="color:black;">{{ $pins->body}}</p>
                                @foreach($pins->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                            <p class="card-text"></p>
                            @if($pins->users()->where('user_id', Auth::id())->exists())
                                <form action="{{ route('unfavorites', $pins) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="&#xf164; LIKE！ {{ $pins->users()->count() }}" class="fas btn btn-primary">
                                </form>
                            @else
                                <form action="{{ route('favorites', $pins) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="&#xf164; LIKE！ {{ $pins->users()->count() }}" class="fas btn btn-link">
                                </form>
                            @endif
                        </a>
                    </div>
                    <br>
                    @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
function initMap() {
    
    // Laravelからpins -> text:「住所」が入った 配列を addresses 渡す。
    var addresses = [];
    const pin = @json($pin);
    for(let i in pin) {
    addresses.push(pin[i].location);
    }

    console.log(pin);

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
                            content:  `<a href='/post/${ pin[i].id }'>${ pin[i].text }</a>`,
                            //pins->body を吹き出しに表示させ pins->idをパラメーターに使い詳細ページに遷移。
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
@endsection