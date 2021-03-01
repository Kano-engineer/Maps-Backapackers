@extends('layouts.app')

@section('content')
<title>My Profile</title>

<div class="container">
    <div class="row">
        <div class="col-xs-6 col-md-4">
            <!-- 3/1 Update:sidebar in card -->
            <div class="card" style="width:;">
            <!-- User's image -->
                @if ($user_images->isEmpty()) 
                    <img style="" src="{{ URL::asset('image/4.jpg') }}" />
                @else
                    @foreach ($user_images as $user_image)
                        <img style="" src="{{ asset('storage/' . $user_image['file_name']) }}">
                        <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            @if(Auth::user()->id === $user->id)
                                <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                            @endif
                        </form>
                    @endforeach
                @endif
                <div>
                @if ($errors->has('file'))
                    @foreach($errors->all() as $error)
                    <font color =red>*{{ $error }}</font>
                    @endforeach
                @endif
                </div>
                @if(Auth::user()->id === $user->id)
                    <form action="/profile/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="photo"></label>
                        <input type="file" class="form-control" name="file">
                        <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
                    </form>
                @endif
                    <div class="card-body">
                    <h4><i class="fas fa-user">USER：{{ $user->name }}</i></h4>
                    <!-- Follow button:Display only in other users' profiles  -->
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
                    <!-- Following / Followers -->
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
                    <div>
                        @if ($errors->has('comment_profile'))
                            @foreach($errors->all() as $error)
                            <font color =red>*{{ $error }}</font>
                            @endforeach
                        @endif
                    </div>
                    @if(Auth::user()->id === $user->id)
                        <form action="/profile/comment/{{ $user->id }}" method="post">
                            {{ csrf_field() }}
                            <input name="comment_profile" placeholder="自己紹介コメント">
                            <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                        </form>
                    @endif
                    @foreach ($comments as $comment)
                    <p class="card-text" style="color:#094067;">{{ $comment ->comment}}</p>
                            @if(Auth::user()->id === $user->id)
                                <form action="{{ action('ProfileController@destroyComment', $comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @endif
                    @endforeach
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a></li>
                        <li class="list-group-item"><a href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a></li>
                    </ul>
                </div>
            <p></p>
        </div>

        <div class="col-xs-6 col-md-8">
            <!-- TODO:Use tab menu for switching between list and like -->
            <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">投稿一覧</i></h5>
            @foreach ($pin as $pin)
                <div class="card">
                    <h5 class="card-header" style="color:#094067;">{{ $pin->text }}</h5>
                        <div class="card-body">
                            @if ($pin->photos->isEmpty()) 
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                            @else
                                @foreach($pin->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                            @endif
                                <p class="card-text"></p>
                                <div class="d-flex flex-row">
                                    <div class="p-2">
                                        <a href="/post/{{$pin->id}}" class="btn btn-primary"><i class="fas fa-globe-europe">MAPを見る</i></a>
                                    </div>
                                    <div class="p-2">
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
                                    </div>
                                </div>
                        </div>
                </div>
                <br>
            @endforeach
            
            <br>
            <!-- TODO:Display image -->
            <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">いいねした投稿(実装中：画像表示予定）</i></h5>
            @foreach ($user->favorites as $favorite)
                <div class="card">
                    <h5 class="card-header" style="color:#094067;">{{ $favorite->text }}</h5>
                        <div class="card-body">
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                                <p class="card-text"></p>
                                <div class="d-flex flex-row">
                                    <div class="p-2">
                                        <a href="/post/{{$favorite->id}}" class="btn btn-primary"><i class="fas fa-globe-europe">MAPを見る</i></a>
                                    </div>
                                    <div class="p-2">
                                        @if($favorite->users()->where('user_id', Auth::id())->exists())
                                            <form action="{{ route('unfavorites', $favorite) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="&#xf164;Like {{ $favorite->users()->count() }}" class="fas btn btn-primary">
                                            </form>
                                        @else
                                            <form action="{{ route('favorites', $favorite) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="&#xf164;Like {{ $favorite->users()->count() }}" class="fas btn btn-link">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                        </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>
@endsection

