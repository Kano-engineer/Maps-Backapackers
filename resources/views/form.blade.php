@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                    <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="padding:5px" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="border-radius: 50%;padding:5px" src="{{ $image['path'] }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                        <br>
                        <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ Auth::user()->name }}</h5>
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
            @if ($errors->has('text'))
                <ul>
                    <font color =red>*{{$errors->first('text')}}</font>
                </ul>
            @endif
            @if ($errors->has('location'))
                <ul>
                    <font color =red>*{{$errors->first('location')}}</font>
                </ul>
            @endif
            <form action="/post" method="POST" class=".form-control:focus" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%;">
                        <h5 class="card-header" style="color:#094067;">
                            <div class="d-flex flex-row">
                                <div class="p-2">
                                    @if (Auth::user()->images->isEmpty()) 
                                        <a href="/profile/{{Auth::user()->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                    @else
                                        @foreach(Auth::user()->images as $image)
                                        <a href="/profile/{{Auth::user()->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2"> 
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{Auth::user()->user_id}}"><i class="fas">{{Auth::user()->name}}</i></a><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="p-2">
                                    <input class="form-control" name="text"  id="" placeholder="例：「地元のパン屋」" value="{{ old('text') }}">
                                </div>
                                <div class="p-2">
                                    <small><font color =red>*必須</font></small>
                                </div>
                            </div>
                        </h5>
                            <div class="card-body">
                                <textarea class="form-control" name="body" value="" placeholder="とっておきの「ローカル」な情報をシェアしよう！：「ここの景色が綺麗」、「地元の人しか知らないお店」" rows="5">{{ old('body') }}</textarea>
                            <p class="card-text"></p>
                                <label style="color:#3490dc"><i class="fas fa-images"></i>Photos</label>
                                <input type="file" name="file" class="form-control" accept='image/*' onchange="previewImage(this);">
                                <br>
                                <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:300px;">
                                <br>
                                <br>
                                <font color =red>*地図を検索➡︎クリック➡︎マーカー情報は必須です</font>
                                <div class="map_wrapper">
                                    <div id="gmap" class="gmap"></div>
                                </div>
                            </div>
                    </div>
                    <br>
                        <button type="submit" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;"><i class="fas fa-edit">Share Your Travel</i></button>            
                </div> 
                <input style="display:none;" name="location"  id="output" placeholder="address">
            </form>
        </div>
    </div>
</div>

<!-- この</div>がないとJavaScript動かない -->
</div>
<form style="text-align:center;" onsubmit="return false;">
    <input style=";" type="" value="" placeholder="検索" id="address2">
    <button style=";" type="" value="" id="map_button2">検索</button>
</form>
<form style="display:none;" onsubmit="return false;">
    <input style=";" type="" value="日本" placeholder="初期値" id="address">
    <button style=";" type="" value="" id="map_button">を初期表示</button>
</form>

  <!-- Output longitude -->
  <input style="display:none;" type="text" id="lng" value=""><br>
  <!-- Output latitude -->
  <input style="display:none;" type="text" id="lat" value=""><br>

<script>

function previewImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function() {
		document.getElementById('preview').src = fileReader.result;
	});
	fileReader.readAsDataURL(obj.files[0]);
}

var getMap = (function() {
  function codeAddress(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();

    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 4,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // 地図を表示させるインスタンスを生成
    var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
    
    //マーカー変数用意
    var marker;

    // geocoder.geocode()メソッドを実行 
    geocoder.geocode( { 'address': address}, function(results, status) {
       
      // ジオコーディングが成功した場合
      if (status == google.maps.GeocoderStatus.OK) {
         
        // 変換した緯度・経度情報を地図の中心に表示
        map.setCenter(results[0].geometry.location);
         
        //☆表示している地図上の緯度経度
        document.getElementById('lat').value=results[0].geometry.location.lat();
        document.getElementById('lng').value=results[0].geometry.location.lng();

      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      } 
    });

    var markers = [];
    
    map.addListener('click', function(e){

        /* 既存のマーカーを削除する。 */
        if (markers.length > 0) {
        /* 既存マーカーが参照渡しで渡されているので、marker.setMap(null)で削除できる */
        markers.forEach(marker => marker.setMap(null));
        }

      //reverse geodcording
      geocoder.geocode({location: e.latLng}, function(results, status){
        if(status === 'OK' && results[0]) {

            var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,
            title: results[0].formatted_address,
            animation: google.maps.Animation.DROP
        });

          document.getElementById('output').value=results[0].formatted_address;
          
          /*
           * markers.push(marker)は参照渡しになることを利用する。
           * https://webtechdays.com/?p=221
           */
          markers.push(marker);
          
          //Delete marker 
          infoWindow.addListener('closeclick', function(){
            marker.setMap(null);
          });
        }else if(status === 'ZERO_RESULTS') {
          alert('不明なアドレスです： ' + status);
          return;
        }else{
          alert('失敗しました： ' + status);
          return;
        }
      });
    });
  }

  function codeAddress2(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();

    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // 地図を表示させるインスタンスを生成
    var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
    
    //マーカー変数用意
    var marker;

    // geocoder.geocode()メソッドを実行 
    geocoder.geocode( { 'address': address}, function(results, status) {
       
      // ジオコーディングが成功した場合
      if (status == google.maps.GeocoderStatus.OK) {
         
        // 変換した緯度・経度情報を地図の中心に表示
        map.setCenter(results[0].geometry.location);
         
        //☆表示している地図上の緯度経度
        document.getElementById('lat').value=results[0].geometry.location.lat();
        document.getElementById('lng').value=results[0].geometry.location.lng();

      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      } 
    });

    var markers = [];
    
    map.addListener('click', function(e){

        /* 既存のマーカーを削除する。 */
        if (markers.length > 0) {
        /* 既存マーカーが参照渡しで渡されているので、marker.setMap(null)で削除できる */
        markers.forEach(marker => marker.setMap(null));
        }

      //reverse geodcording
      geocoder.geocode({location: e.latLng}, function(results, status){
        if(status === 'OK' && results[0]) {

            var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,
            title: results[0].formatted_address,
            animation: google.maps.Animation.DROP
        });

          document.getElementById('output').value=results[0].formatted_address;
          
          /*
           * markers.push(marker)は参照渡しになることを利用する。
           * https://webtechdays.com/?p=221
           */
          markers.push(marker);
          
          //Delete marker 
          infoWindow.addListener('closeclick', function(){
            marker.setMap(null);
          });
        }else if(status === 'ZERO_RESULTS') {
          alert('不明なアドレスです： ' + status);
          return;
        }else{
          alert('失敗しました： ' + status);
          return;
        }
      });
    });
  }

  //inputのvalueで検索して地図を表示
  return {
    getAddress: function() {
      // ボタンに指定したid要素を取得
      var button = document.getElementById("map_button");
       
      // ボタンが押された時の処理
      button.onclick = function() {
        // フォームに入力された住所情報を取得
        var address = document.getElementById("address").value;
                                           // 取得した住所を引数に指定してcodeAddress()関数を実行
        codeAddress(address);
      }

            // ボタンに指定したid要素を取得
            var button2 = document.getElementById("map_button2");
       
       // ボタンが押された時の処理
       button2.onclick = function() {
         // フォームに入力された住所情報を取得
         var address = document.getElementById("address2").value;
                                            // 取得した住所を引数に指定してcodeAddress()関数を実行
         codeAddress2(address);
       }
      
      //読み込まれたときに地図を表示
      window.onload = function(){
        // フォームに入力された住所情報を取得
        var address = document.getElementById("address").value;
        // 取得した住所を引数に指定してcodeAddress()関数を実行
        codeAddress(address);
      }
    }
  };
})();
getMap.getAddress();
</script>
<!-- Use Google Maps API / Geocording API -->
<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE"></script>
@endsection