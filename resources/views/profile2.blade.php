@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                   <!-- User's image -->
                   @if ($user_images->isEmpty()) 
                        <img style="padding:5px" src="{{ URL::asset('image/profile.png') }}" />
                    @else
                        @foreach ($user_images as $user_image)
                            <img style="border-radius: 50%;padding:5px" src="{{ asset('storage/' . $user_image['file_name']) }}">
                            <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                @if(Auth::user()->id === $user->id)
                                    <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                @endif
                            </form>
                        @endforeach
                    @endif
                    <!-- Upload image -->
                    @if(Auth::user()->id === $user->id)
                        @if($user_images->count())
                            <table border="1">
                            </table>
                        @else
                        <br>
                        @if ($errors->has('file'))
                            <ul>
                                <font color =red>*{{$errors->first('file')}}</font>
                            </ul>
                        @endif
                            <form action="/profile/upload" method="post" style="display:flex;justify-content: center;margin-right:8px;margin-left:10px;" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file"accept='image/*' onchange="previewImage(this);"  value="{{ old('file') }}">
                                    <div class="input-group-append">
                                        <button style="" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-images"></i></button>
                                    </div>
                                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
                                </div>
                            </form>
                        @endif
                    @endif
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
                                <ul>
                                    <font color =red>*{{$errors->first('comment_profile')}}</font>
                                </ul>
                            @endif
                        </div>
                        @if(Auth::user()->id === $user->id)
                            @if($comments->count())
                                <table border="1">
                                </table>
                            @else
                                <form action="/profile/comment/{{ $user->id }}" method="post" style="display:flex;justify-content: center;margin-right:8px;margin-left:8px;">
                                    {{ csrf_field() }}
                                    <div class="input-group mb-3">
                                        <input name="comment_profile" type="text" class="form-control" placeholder="自己紹介をどうぞ"  value="{{ old('comment_profile') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endif
                        @foreach ($comments as $comment)
                            <div class="d-flex flex-row" style="display:flex;justify-content: center;">
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
                        <!-- Following / Followers -->
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
                                    <input style="text-decoration: none;" type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                </form>
                            @endif
                        @else
                                <form action="" method="POST" style="display: flex;justify-content: flex-end;margin-right: 8px;margin-top: 16px;">
                                    @csrf
                                    <a type="submit" style="text-decoration: none;" class="btn btn-primary btn-sm" href="profile"><i class="fas fa-user-edit"></i> SAVE</a>
                                </form>
                        @endif
                        <p></p>
                </div>
                <!-- class="card" -->
                <p></p>
            </div>
            <div class="col-md-9">
                
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
@endsection