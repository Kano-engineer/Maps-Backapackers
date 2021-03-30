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
    <div class="row">
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <!-- 3/1 Update:sidebar in card -->
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
                        <a href="/map" type="button" class="btn btn-primary"><i class="fas fa-globe-europe">MAP</i></a>
                        <p></p>
                        <a href="/post" type="button" class="btn btn-primary"><i class="fas fa-comment-dots">TALK</i></a>
                </div>
            <p></p>
        </div>

        <div class="col-md-9">     
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
                        <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas fa-user">{{$pin->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pin->text }}</i>
                    </div>
                    </div>
                </h5>
                <div class="card-body">
                            <p class="card-text" style="color:black;">{{ $pin->created_at}}</p>
                            <p class="card-text" style="color:black;">{{ $pin->body}}</p>
                                @foreach ($photos as $photo)
                                        <a href="{{ asset('storage/' . $photo['photo']) }}" target="_blank"><img src="{{ asset('storage/' . $photo['photo']) }}" style="width:380px;height:300px;" alt="" border="0"></a>
                                    @if(Auth::user()->id === $pin->user_id)
                                        <form action="{{ action('PhotoController@destroy', $photo->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                                    <br>
                                @endforeach
                            @if ($errors->has('file'))
                                @foreach($errors->all() as $error)
                                    <font color =red>*{{ $error }}</font>
                                @endforeach
                            @endif
                            @if(Auth::user()->id === $pin->user_id)
                                <form action="/store/{{$pin->id}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="form-control" name="file">
                                    <button type="submit"  class='btn btn-primary  btn-sm'><i class="fas fa-images">画像アップロード</i></button>
                                </form>
                            @endif
                            <br>
                    @if($pin->users()->where('user_id', Auth::id())->exists())
                        <form action="{{ route('unfavorites', $pin) }}" method="POST">
                            @csrf
                            <input type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-primary">
                        </form>
                    @else
                        <form action="{{ route('favorites', $pin) }}" method="POST">
                            @csrf
                            <input style="text-decoration:none;" type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-link">
                        </form>
                    @endif
                    <p class="card-text"></p>
                        <div class="map_wrapper">
                            <div id="gmap" class="gmap"></div>
                        </div>
                    
                    <br>
                    <div>
                        @if ($errors->has('comment'))
                            @foreach($errors->all() as $error)
                            <font color =red>*{{ $error }}</font>
                            @endforeach
                        @endif
                    </div>
                    <div>
                        <form action="/comment/{{$pin -> id}}" method="post">
                            {{ csrf_field() }}
                            <input type="search" name="comment" placeholder="コメント">
                            <button type="submit"><i class="fas fa-comment">コメント</i></button>
                        </form>
                    </div>

                    <br>

                    <div class="container">
                        @foreach ($comments as $comments)
                            <div class="d-flex flex-row">
                                <div class="p-2">
                                    @if ($comments->user->images->isEmpty()) 
                                        <a href="/profile/{{$comments->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                    @else
                                        @foreach($comments->user->images as $image)
                                        <a href="/profile/{{$comments->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2">
                                    <a style="color:#3da9fc;" href="/profile/{{$comments->user_id}}"><i class="fas fa-user"></i>{{$comments->user->name}}</a>
                                </div>
                                <div class="p-2">
                                    <p style="color:#094067;">{{ $comments->comment }}</p>
                                </div>
                                <div class="p-2">
                                    @if(Auth::user()->id === $comments->user_id)
                                        <form action="{{ action('PinController@destroyComment', $comments->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                        </form> 
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                <!-- Card -->
                </div>
                    <div class="card-footer text-muted">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                @if(Auth::user()->id === $pin->user_id)
                                    <a type="button" class="btn btn-primary btn-sm" href="/edit/{{$pin->id}}"><i class="fas fa-user-edit">EDIT</i></a>
                                @endif
                            </div>
                            <div class="p-2">
                                @if(Auth::user()->id === $pin->user_id)
                                    <form action="{{ action('PinController@destroy', $pin->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt">DELETE</i></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Card -->
            </div>
        <!-- <div class="col-md-9"> -->
        </div>
    </div>
<!-- 何故か</div>が無いと動かない。sectionが邪魔？➡︎強引にフォーム作成？ -->
</div>
<!-- Search longitude and latitude by address -->
<form style="text-align:center;" onsubmit="return false;">
    <input style=";" type="" value="{{optional($pin) -> text}}" id="address">
    <button style=";" type="" value="" id="map_button">場所をザックリ検索</button>
</form>
<!-- Output longitude -->
<input style="" type="text" id="lng" value=""><br>
<!-- Output latitude -->
<input style="" type="text" id="lat" value=""><br>
<input class="" name="text"  id="output" placeholder="住所">

<script>
var getMap = (function() {
  function codeAddress(address) {
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
        
        // // マーカー設定
        // marker = new google.maps.Marker({
        //   map: map,
        //   position: results[0].geometry.location
        // });
       
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