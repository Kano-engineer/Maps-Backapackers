@extends('layouts.app')
<style>
    /* Responsive */
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

    
</style>
@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                    <div class="card" style="width:;">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                            <p></p>
                            <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user">{{ Auth::user()->name }}</i></a>
                            <p></p>
                            <a href="/map2" type="button" class="btn btn-primary"><i class="fas fa-globe-europe"></i>MAP</a>
                            <p></p>
                            <a href="/post" type="button" class="btn btn-primary"><i class="fas fa-comment-dots"></i>TALK</a>
                            <p></p>
                            <a href="/index" type="button" class="btn btn-primary"><i class="fas fa-globe-europe"></i>SEARCH</a>
                    </div>
                    <p></p>
                </div>
        </div>

        <div class="col-md-9">
            <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container">
            <input id="tab1" type="radio" name="tab_item" checked>
            <label class="tab_item" for="tab1"><i class="fas fa-globe-europe"></i> MAP</label>
            <input id="tab2" type="radio" name="tab_item">
            <label class="tab_item" for="tab2"><i class="fas fa-stream"></i> TIMELINE</label>
            <!-- TAB:TIMELINE -->
            <div class="tab_content" id="tab1_content">
                <div class="tab_content_description">
                    <!-- Form -->
                    <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                    <br>
                    <br>
                    <!-- MAP -->
                    <div class="map_wrapper">
                        <div id="gmap" class="gmap"></div>
                    </div>
                </div>
            </div>
            <!-- TAB:LIKES -->
            <div class="tab_content" id="tab2_content">
                <div class="tab_content_description">
                    <!-- Form -->
                    <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                    <br>
                    <br>
                    <!-- TIMELINE -->
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
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pins->user_id}}"><i class="fas fa-user">{{$pins->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pins->text }}</i>
                                </div>
                            </div>
                        </h5>
                        <a href="/post/{{$pins->id}}" class="card-body">
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
    const pins = @json($pins);
    for(let i in pins) {
    addresses.push(pins[i].location);
    }

    console.log(pins);

    var infoWindow = []; //Q:pins -> body を吹き出しに表示させるため配列化？

    var id = []; //Q:pins ->idをパラメーターに使い遷移させるため配列化？
    for(let i in pins) {
    id.push(pins[i].id);
    }
    console.log(id);

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
                            content:  `<a href='post/${ id[i] }'>${ pins[i].text }</a>`, // Q:pins->body を吹き出しに表示させ pins->idをパラメーターに使い詳細ページに遷移させたい。
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
            zoom: 5 // 地図のズームを指定
        };//地図作成のオプションのうちcenterとzoomは必須
        map.setOptions(opt);//オプションをmapにセット
    }//function aftergeo終了

};//function initMap終了
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>
@endsection
