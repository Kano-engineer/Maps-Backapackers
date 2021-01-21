@extends('layouts.app')
<title>PIN</title>

@section('content')
<h1>PIN</h1>
<div>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
</div>

<!-- 画像アップロード -->
<form action="/store/{{$pin->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- <label for="photo">画像アップロード:</label> -->
    <input type="file" class="form-control" name="file">
    <br>
      <input type="submit" value="画像アップロード">
</form>

<h1>・{{optional($pin) -> text}}</h1>
        <!-- 写真削除 idで判別-->
        <form action="{{ action('PinController@destroy', $pin->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="ピンを削除" onClick="delete_alert(event);return false;">
        </form>

@foreach ($photos as $photo)
        <img src="{{ asset('storage/' . $photo['photo']) }}">
        <br>
        <!-- 写真削除 idで判別-->
        <form action="{{ action('PhotoController@destroy', $photo->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="写真を削除" onClick="delete_alert(event);return false;">
        </form>
    @endforeach

<script>
    function delete_alert(e){
        if(!window.confirm('本当に削除しますか？')){
        //   window.alert('キャンセルされました'); 
          return false;
        }
      document.deleteform.submit();
        };
</script>

@endsection