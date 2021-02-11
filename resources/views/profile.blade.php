@extends('layouts.app')

@section('content')
<title>My Profile</title>
<div class="container">
    <div class="row">
        <div class="col-xs-6 col-md-4">
        <h1><i style="color:#094067;" class="fas fa-user"></i>{{ $user->name }}</h1>
    <!-- 自分以外のユーザーのみフォロー機能表示 -->
    @if(Auth::user()->id !== $user->id)
        @if($user->followUsers()->where('following_user_id', Auth::id())->exists())
        <form action="{{ route('unfollow', $user) }}" method="POST">
            @csrf
            <input type="submit" value="&#xf164;Following" class='fas btn btn-primary'>
        </form>
        @else
        <form action="{{ route('follow', $user) }}" method="POST">
            @csrf
            <input type="submit" value="&#xf164;Follow Me" class="fas btn btn-link">
        </form>
        @endif
    @endif
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
    <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
</form>
@endif

<div>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->has('comment_profile'))
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
</div>

@if ($user_images->isEmpty()) 
    <img style="width:350px;height:250px;" src="{{ URL::asset('image/4.jpg') }}" />
@else
@foreach ($user_images as $user_image)
    <img style="width:350px;height:250px;" src="{{ asset('storage/' . $user_image['file_name']) }}">
    <!-- 写真削除 idで判別-->
    <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                @csrf
                @method('DELETE')
                @if(Auth::user()->id === $user->id)
                <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                @endif
    </form>
@endforeach
@endif

<div class="d-flex flex-row">

<div class="p-2">
<p class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">Following：{{ $user->follows()->count() }}</i></p>
@foreach ($user->follows as $follow)
<p style="color:#094067;"><a style="color:#3da9fc;" href="/profile/{{$follow->id}}"><i class="fas fa-user"></i>{{$follow->name}}</a>
@endforeach
</div>

<div class="p-2">
<p class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">Followers：{{ $user->followUsers()->count() }}</i></p>
@foreach ($user->followusers as $followuser)
<p style="color:#094067;"><a style="color:#3da9fc;" href="/profile/{{$followuser->id}}"><i class="fas fa-user"></i>{{$followuser->name}}</a>
@endforeach
</div>
</div>

@if(Auth::user()->id === $user->id)
<form action="/profile/comment/{{ $user->id }}" method="post">
    {{ csrf_field() }}
    <input type="search" name="comment_profile" placeholder="自己紹介コメント">
    <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
</form>
@endif
<br>
<h5 style="color:#094067;"><i class="fas fa-angle-right">自己紹介</i></h5>
@foreach ($comments as $comment)
    <p style="color:#094067;">{{ $comment ->comment}}</p>
    @if(Auth::user()->id === $user->id)
    <form action="{{ action('ProfileController@destroyComment', $comment->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
    </form>
    @endif
@endforeach

</div>

<br>

<br>
<div class="col-xs-6 col-md-8">
<!--likes  -->
<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">投稿一覧</i></h5>
    @foreach ($pin as $pin)
    <div class="card">
<h5 class="card-header" style="color:#094067;">{{ $pin->text }}</h5>
<div class="card-body">
<img style="width:200px;height:150px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
<h5 class="card-title">SNS for Backpackers</h5>
<p class="card-text"></p>
<a href="post/{{$pin->id}}" class="btn btn-primary">Go somewhere</a>
</div>
</div>
<br>
    @endforeach
    <script src="{{ asset('/js/alert.js') }}"></script>
<br>
<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">いいねした投稿</i></h5>
<!-- 多対多（Many to Many）foreachでクラスに分解して表示 -->
@foreach ($user->favorites as $favorite)
<p><a type="button"  style="color:#3da9fc;" href="/post/{{$favorite->id}}"><i class="fas fa-map-marker-alt"></i></a><a style="color:#094067;">{{ $favorite->text }}</a></p>
@endforeach
</div>
</div>
</div>
@endsection