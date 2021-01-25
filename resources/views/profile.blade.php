@extends('layouts.app')
<title>My Profile</title>

@section('content')
    <h1>My Profile：{{ $user->name }}</h1>

    <div>
@if ($errors->has('file'))
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
   </div>

@if(Auth::user()->id === $user->id)
<form action="profile/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo"></label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit" value="画像アップロード">
</form>
@endif

<br>

<div>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->has('comment_profile'))
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
</div>

@if(Auth::user()->id === $user->id)
<div>
    <form action="/profile/comment/{{ $user->id }}" method="post">
        {{ csrf_field() }}
        <input type="search" name="comment_profile" placeholder="自己紹介">
        <button type="submit">コメントを作成</button>
    </form>
</div>
@endif

<div class="container">
    @foreach ($comments as $comment)
        <p>◆自己紹介：{{ $comment ->comment}}</p>
        @if(Auth::user()->id === $user->id)
        <form action="{{ action('ProfileController@destroyComment', $comment->id) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="自己紹介を削除" onClick="delete_alert(event);return false;">
        </form>
        @endif
    @endforeach
</div>

<br>
@foreach ($user_images as $user_image)
    <img src="{{ asset('storage/' . $user_image['file_name']) }}">
    <br>

    <!-- 写真削除 idで判別-->
    <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                @csrf
                @method('DELETE')
                @if(Auth::user()->id === $user->id)
                <input type="submit" value="削除" onClick="delete_alert(event);return false;">
                @endif
    </form>
@endforeach

<div class="container">
<p>◆投稿一覧◆</p>
    @foreach ($pin as $pin)
        <p>▼<a style="color:blue;" href="/post/{{$pin->id}}">PIN</a>：{{ $pin->text }}</p>
        <p></p>
    @endforeach
</div>
    <script src="{{ asset('/js/alert.js') }}"></script>
@endsection