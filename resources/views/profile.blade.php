@extends('layouts.app')

@section('content')
<title>My Profile</title>

<div class="container">
    <div class="row">
        <div class="col-xs-6 col-md-4">
                <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
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

            @if ($user_images->isEmpty()) 
                <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}" />
            @else
                @foreach ($user_images as $user_image)
                    <img style="width:250px;height:200px;" src="{{ asset('storage/' . $user_image['file_name']) }}">
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

            <div>
            @if ($errors->has('comment_profile'))
                @foreach($errors->all() as $error)
                <font color =red>*{{ $error }}</font>
                @endforeach
            @endif
            </div>

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
                <p></p>
                <a type="button" class="btn btn-primary btn-sm" href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a>
                <br>
                <p></p>
                <a type="button" class="btn btn-primary btn-sm" href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                <p></p>
                <br>
        </div>

        <br>

        <div class="col-xs-6 col-md-8">
            <!-- TODO:Use tab menu for switching between list and likes -->
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

            <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-angle-right">いいねした投稿</i></h5>
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

