@extends('layouts.app')

@section('content')
<title>My Profile</title>
<div class="container">
    <div class="row">
    <div class="col-xs-6 col-md-4"></div>
    <div class="col-xs-6 col-md-4">

    <h1><i style="color:#094067;" class="fas fa-user"></i>{{ $user->name }}</h1>

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
    <img style="width:380px;height:250px;" src="{{ URL::asset('storage/noimage.png') }}" />
@else
@foreach ($user_images as $user_image)
    <img style="width:380px;height:250px;" src="{{ asset('storage/' . $user_image['file_name']) }}">
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


<br>
<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">投稿一覧</i></h5>
    @foreach ($pin as $pin)
        <p><a type="button"  style="color:#3da9fc;" href="/post/{{$pin->id}}"><i class="fas fa-map-marker-alt"></i></a><a style="color:#094067;">{{ $pin->text }}</a></p>

    @endforeach
    <script src="{{ asset('/js/alert.js') }}"></script>



<br>
<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">いいねした投稿</i></h5>

<br>
<h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">フォロー中</i></h5>


@endsection