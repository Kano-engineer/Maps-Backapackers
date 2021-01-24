@extends('layouts.app')

@section('content')
<title>PIN </title>

<h1 style="color:blue;">PIN</h1>

<div>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
</div>

@if(Auth::user()->id === $pin->user_id)
        <form action="/store/{{$pin->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="form-control" name="file">
                <br>
                <input type="submit" value="画像アップロード">
        </form>
@endif

<h1>・{{optional($pin) -> text}} by <a style="color:blue;" href="/profile/{{$pin->user_id}}">{{$pin->user->name}}</a></h1>

@if(Auth::user()->id === $pin->user_id)
<a style="color:blue;" href="/edit/{{$pin->id}}">地名/住所を編集(地図を再検索)</a>
@endif

@if(Auth::user()->id === $pin->user_id)
        <form action="{{ action('PinController@destroy', $pin->id) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="ピンを削除" onClick="delete_alert(event);return false;">
        </form>
@endif

<br>
@foreach ($photos as $photo)
        <img style="" src="{{ asset('storage/' . $photo['photo']) }}">
        <br>
        <!-- 写真削除 idで判別-->
        @if(Auth::user()->id === $pin->user_id)
        <form action="{{ action('PhotoController@destroy', $photo->id) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="写真を削除" onClick="delete_alert(event);return false;">
        </form>
        @endif
        <p>写真へのコメント：ex.夕焼けが綺麗だった。くまモンがいた。*ユーザーのみ編集可能 photo_id</p>
@endforeach

<script src="{{ asset('/js/alert.js') }}"></script>

<!-- <div id="map" style="height:500px;width:1000" ></div>
<script src="{{ asset('/js/result.js') }}"></script> 
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer>
</script> -->

<form type="hidden" onsubmit="return false;">
  <input style="display:none;" type="" value="{{optional($pin) -> text}}" id="address">
  <button style="display:none;" type="" value="" id="map_button">検索</button>
</form>
<!-- 地図を表示させる要素 -->
<div class="map_box01"><div id="map-canvas" style="width: 1000px;height: 500px;"></div></div>
<p>*地図上をクリックするとピンを移動できます。</p>

<br>

<p><a style="color:blue;" href="/chat/{{$pin -> id}}">◆共有チャット◆</a></p>
<p>ex.ここの道が走りやすい。この近くに美味しいラーメン屋があるよ〜pin_id</p>

<!-- チャット -->
    <!-- <meta charset="UTF-8">
    <title>チャット</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="app">
        <example-component></example-component>
    </div> 
    <script src="{{ mix('js/app.js') }}"></script> -->
<!-- チャット -->

<!-- 緯度  -->
<input style="display:none;" type="text" id="lat" value=""><br>
<!-- 経度 -->
<input style="display:none;" type="text" id="lng" value=""><br>

<!-- APIを取得 -->
<script src="{{ asset('/js/getAddress.js') }}"></script> 
<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE"></script>

@endsection