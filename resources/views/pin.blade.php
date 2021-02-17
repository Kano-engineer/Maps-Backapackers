@extends('layouts.app')

@section('content')
<title>PIN</title>

<div class="container">
<div class="row">

<div class="col-md-4">
        <!-- side -->
@if ( Auth::check() )
<ul class="navbar-nav mr-auto">
        <div class="sidebar">
            <div class="sidebar-item">
                <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                    <p><a href="/profile" class="btn btn-primary">MyProfile</a></p>
                <div class="btn-sidebar">

                    <a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                    
                </div>
            </div>
        </div>
    </ul>
@endif
</div>

<div class="col-md-4">
<!-- main -->

<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-map-marker-alt">{{optional($pin) -> text}} by </i><a style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas fa-user"></i>{{$pin->user->name}}</a></h5>

@if($pin->users()->where('user_id', Auth::id())->exists())
      <form action="{{ route('unfavorites', $pin) }}" method="POST">
         @csrf
         <input type="submit" value="&#xf164;Like {{ $pin->users()->count() }}" class="fas btn btn-primary">
      </form>
@else
      <form action="{{ route('favorites', $pin) }}" method="POST">
        @csrf
        <input type="submit" value="&#xf164;Like {{ $pin->users()->count() }}" class="fas btn btn-link">
      </form>
 @endif

@if(Auth::user()->id === $pin->user_id)
<a type="button" class="btn btn-primary btn-lg active btn-sm" href="/edit/{{$pin->id}}"><i class="fas fa-user-edit">地名/住所を編集(地図を再検索)</i></a>
@endif

@if(Auth::user()->id === $pin->user_id)
        <form action="{{ action('PinController@destroy', $pin->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt">投稿削除</i></button>
        </form>
@endif

<br>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->has('file'))
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
@if(Auth::user()->id === $pin->user_id)
        <form action="/store/{{$pin->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="form-control" name="file">
                <button type="submit"  class='btn btn-primary btn-lg active btn-sm'><i class="fas fa-images">画像アップロード</i></button>
        </form>
@endif

@if ($photos->isEmpty()) 
    <img style="width:380px;height:300px;" src="{{ URL::asset('image/noimage.png') }}" />
@else
@foreach ($photos as $photo)
        <img style="width:380px;height:300px;" src="{{ asset('storage/' . $photo['photo']) }}">
        <br>
        <!-- 写真削除 idで判別-->
        @if(Auth::user()->id === $pin->user_id)
        <form action="{{ action('PhotoController@destroy', $photo->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
        </form>
        @endif
@endforeach
@endif

<br>

<script src="{{ asset('/js/alert.js') }}"></script>
 
<form type="hidden" onsubmit="return false;">
  <input style="display:none;" type="" value="{{optional($pin) -> text}}" id="address">
  <button style="display:none;" type="" value="" id="map_button">検索</button>
</form>

</div>

<br>

<div class="col-md-4">

<!-- 地図を表示させる要素 -->
<div class="map_box01"><div id="map-canvas" style="width:500px;height:300px;"></div></div>

<!-- <p>*地図上をクリックするとピンを移動できます。</p> -->
<br>

<div>
<!-- エラーメッセージ。なければ表示しない -->
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
        <p style="color:#094067;"><a style="color:#3da9fc;" href="/profile/{{$comments->user_id}}"><i class="fas fa-user"></i>{{$comments->user->name}}</a>
        {{ $comments->comment }}
        </p>
        @if(Auth::user()->id === $comments->user_id)
        <!-- <p>{{$comments->created_at}}</p> -->
        <form action="{{ action('PinController@destroyComment', $comments->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
        </form>
            
        @endif
    @endforeach
</div>

<!-- 緯度  -->
<input style="display:none;" type="text" id="lat" value=""><br>
<!-- 経度 -->
<input style="display:none;" type="text" id="lng" value=""><br>

<!-- APIを取得 -->
<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE"></script>
    
<script src="{{ asset('/js/getAddress.js') }}"></script> 

   </div>
</div>
</div>
@endsection