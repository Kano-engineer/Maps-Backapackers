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
                <!-- TODO:update rayout of upload image / follow -> Edit page ? -->
                @if(Auth::user()->id === $user->id)
                    <form action="/profile/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="photo"></label>
                        <input type="file" class="form-control" name="file">
                        <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
                    </form>
                @endif
                    <div class="card-body">
                    <h5><i class="fas fa-user">USER：{{ $user->name }}</i></h5>
                    <!-- Follow button:Display only in other users' profiles  -->
                    @if(Auth::user()->id !== $user->id)
                        @if($user->followUsers()->where('following_user_id', Auth::id())->exists())
                            <form action="{{ route('unfollow', $user) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; Following" class='fas btn btn-primary'>
                            </form>
                            @else
                            <form action="{{ route('follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
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
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <p class="card-text" style="color:#094067;">{{ $comment ->comment}}</p>
                                    @if(Auth::user()->id === $user->id)
                            </div>
                            <div class="p-2">
                                        <form action="{{ action('ProfileController@destroyComment', $comment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  class='btn btn-danger btn-sm' onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="/map"><i class="fas fa-globe-europe">MAP SPACE(実装中：クリックOK)</i></a></li>
                        <li class="list-group-item"><a href="/post"><i class="fas fa-comment-dots">TALK SPACE</i></a></li>
                    </ul>
                </div>
            <p></p>
        </div>

        <div class="col-xs-6 col-md-8">
            <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container">
            <input id="tab1" type="radio" name="tab_item" checked>
            <label class="tab_item" for="tab1">LIST</label>
            <input id="tab2" type="radio" name="tab_item">
            <label class="tab_item" for="tab2">LIKES</label>
            <!-- TAB:LIST -->
            <div class="tab_content" id="tab1_content">
                <div class="tab_content_description">
                <!-- Form -->
                @if ($errors->has('text'))
                <ul>
                @foreach($errors->all() as $error)
                    <font color =red>*{{ $error }}</font>
                @endforeach
                </ul>
                @endif
                <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">Share Your Travel</i></h5>
                    <form action="/post" method="post" class=".form-control:focus">
                        {{ csrf_field() }}
                        <input type="search" name="text" placeholder="Place">
                        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                    </form>
                <br>
                <!-- LIST -->
                @foreach ($pin as $pin)
                <div class="card">
                        <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas fa-user">{{$pin->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pin->text }}</i></h5>
                    <a href="/post/{{$pin->id}}" class="card-body">
                        @if ($pin->photos->isEmpty()) 
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                        @else
                                @foreach($pin->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                        @endif
                            <p class="card-text"></p>
                        @if($pin->users()->where('user_id', Auth::id())->exists())
                            <form action="{{ route('unfavorites', $pin) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-primary">
                            </form>
                        @else
                            <form action="{{ route('favorites', $pin) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; LIKE！ {{ $pin->users()->count() }}" class="fas btn btn-link">
                            </form>
                        @endif
                    </a>
                </div>
                <br>
            @endforeach
                </div>
            </div>
            <!-- TAB:LIKES -->
            <div class="tab_content" id="tab2_content">
                <div class="tab_content_description">
                <!-- Form -->
                @if ($errors->has('text'))
                <ul>
                @foreach($errors->all() as $error)
                    <font color =red>*{{ $error }}</font>
                @endforeach
                </ul>
                @endif
                <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">Share Your Travel</i></h5>
                    <form action="/post" method="post" class=".form-control:focus">
                        {{ csrf_field() }}
                        <input type="search" name="text" placeholder="Place">
                        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                    </form>
                <br>
                <!-- LIKES -->
                @foreach ($user->favorites as $favorite)
                <div class="card">
                        <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$favorite->user_id}}"><i class="fas fa-user">{{$favorite->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $favorite->text }}</i></h5>
                    <a href="/post/{{$favorite->id}}" class="card-body">
                        @if ($favorite->photos->isEmpty()) 
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                        @else
                                @foreach($favorite->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                        @endif
                            <p class="card-text"></p>
                        @if($favorite->users()->where('user_id', Auth::id())->exists())
                            <form action="{{ route('unfavorites', $favorite) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; LIKE！ {{ $favorite->users()->count() }}" class="fas btn btn-primary">
                            </form>
                        @else
                            <form action="{{ route('favorites', $favorite) }}" method="POST">
                                @csrf
                                <input type="submit" value="&#xf164; LIKE！ {{ $favorite->users()->count() }}" class="fas btn btn-link">
                            </form>
                        @endif
                    </a>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>
@endsection

