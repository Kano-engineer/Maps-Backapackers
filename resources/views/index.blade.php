@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                    <!-- 2/28 Update:sidebar in card -->
                        <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                            @if (Auth::user()->images->isEmpty()) 
                                <a href="/profile"><img style="padding:5px" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                            @else
                                @foreach(Auth::user()->images as $image)
                                <a href="/profile"><img style="border-radius: 50%;padding:5px" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                @endforeach
                            @endif
                            <br>
                            <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ Auth::user()->name }}</h5>
                                <p></p>
                                <!-- <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user"> {{ Auth::user()->name }}</i></a> -->
                                <!-- <p></p>
                                <a href="/post/" type="button" class="btn btn-primary"><i class="fas fa-comment-dots"></i>TALK</a> -->
                                <!-- <p></p> -->
                                <!-- <a href="/index/" type="button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</a> -->
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
                            @if ($errors->has('keyword'))
                                <ul>
                                @foreach($errors->all() as $error)
                                    <font color =red>*{{ $error }}</font>
                                @endforeach
                                </ul>
                            @endif
                            <form action="{{url('/books')}}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="keyword" value="{{ old('text') }}">
                                    <div class="input-group-append" >
                                        <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-search"></i> SERACH</button>
                                    </div>
                                </div>
                            </form>

                            @if ($errors->has('keyword2'))
                                <ul>
                                @foreach($errors->all() as $error)
                                    <font color =red>*{{ $error }}</font>
                                @endforeach
                                </ul>
                            @endif
                            <form action="{{url('/books')}}" method="GET">
                                <div class="input-group">
                                    <select class="custom-select" name="keyword2">
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
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> 地名検索</button>
                                    </div>
                                    </div>
                            </form>
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
@endsection