@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <!-- 3/1 Update:sidebar in card -->
                <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="padding:5px" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <!-- S3 -->
                            <!-- <a href="/profile"><img style="border-radius: 50%;padding:5px" src="{{ $image['path'] }}" class="card-img-top" alt="..."></a> -->
                            <!-- Public -->
                            <a href="/profile"><img style="border-radius: 50%;padding:5px" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                        <br>
                        <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ Auth::user()->name }}</h5>
                        <a style="margin-right:8px;margin-left:8px;" href="/index/" type="button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</a>
                        <br>
                </div>
            <p></p>
        </div>

        <div class="col-md-9">     
            <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                    <h5 class="card-header" style="color:#094067;">
                        <div class="d-flex flex-row">
                        <div class="p-2">
                            @if ($pin->user->images->isEmpty()) 
                                <a href="/profile/{{$pin->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                            @else
                                @foreach($pin->user->images as $image)
                                <!-- S3 -->
                                <!-- <a href="/profile/{{$pin->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset( $image['path']) }}" class="card-img-top" alt="..."></a> -->
                                <!-- Public -->
                                <a href="/profile/{{$pin->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                @endforeach
                            @endif
                        </div>
                        <div class="p-2">
                            <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas">{{$pin->user->name}}</i></a><i class="fas fa-map-marker-alt"> {{ $pin->text }}</i>
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
                                        <input style="text-decoration: none;" type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                    </form>
                                @endif
                            @endif
                        </div>
                        </div>
                    </h5>
                <div class="card-body">
                            <p class="card-text" style="color:black;">{{ $pin->created_at}}</p>
                            <p class="card-text" style="color:black;">{{ $pin->body}}</p>
                                @foreach ($photos as $photo)
                                        <!-- S3 -->
                                        <!-- <a href="{{ asset($photo['path']) }}" target="_blank"><img src="{{ $photo['path'] }}" class="img-fluid" alt="" border="0"></a> -->
                                        <!-- Public -->
                                        <a href="{{ asset($photo['path']) }}" target="_blank"><img src="{{ asset('storage/' . $photo['photo']) }}" class="img-fluid" alt="" border="0"></a>
                                    @if(Auth::user()->id === $pin->user_id)
                                        <form action="{{ action('PinController@DestryPhoto', $photo->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                        </form> 
                                    @endif
                                    <br>
                                @endforeach
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
                            <ul>
                                <font color =red>*{{$errors->first('comment')}}</font>
                            </ul>
                        @endif
                    </div>
                    <div>
                        <form action="/comment/{{$pin -> id}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <input name="comment" type="text" class="form-control" placeholder="コメントをどうぞ"  value="{{ old('comment') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="far fa-comment-alt"></i></button>
                                </div>
                            </div>
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
                                        <a href="/profile/{{$comments->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ $image['path'] }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2">
                                    <a style="color:#3da9fc;" href="/profile/{{$comments->user_id}}"><i class="fas"></i>{{$comments->user->name}}</a>
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
                </div>
                
                <!-- card-body」 -->
                    <div class="card-footer text-muted">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                @if(Auth::user()->id === $pin->user_id)
                                    <a type="button" class="btn btn-primary btn-sm" href="/edit/{{$pin->id}}"><i class="fas fa-user-edit"></i> EDIT</a>
                                @endif
                            </div>
                            <div class="p-2">
                                @if(Auth::user()->id === $pin->user_id)
                                    <form action="{{ action('PinController@destroy', $pin->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i> DELETE</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Card」 -->
        </div>
        <!-- <div class="col-md-9"> -->
    </div>
</div>
<!-- 何故か</div>が無いと動かない。sectionが邪魔？➡︎強引にフォーム作成？ -->
</div>
<!-- Search longitude and latitude by address -->
<form style="display:none;" onsubmit="return false;">
    <input style=";" type="" value="{{$pin->location}}" id="address">
    <button style=";" type="" value="" id="map_button">初期情報</button>
</form>
<!-- Output longitude -->
<input style="display:none;" type="text" id="lng" value=""><br>
<!-- Output latitude -->
<input style="display:none;" type="text" id="lat" value=""><br>

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
        
        // マーカー設定
        marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
       
      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      } 
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