@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow:0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);">
                   <!-- User's image -->
                   @if ($user_images->isEmpty()) 
                        <img style="" src="{{ URL::asset('image/profile.png') }}" />
                    @else
                        @foreach ($user_images as $user_image)
                            <img style="border-radius: 50%;" src="{{ asset('storage/' . $user_image['file_name']) }}">
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
                    <!-- Upload image -->
                    @if(Auth::user()->id === $user->id)

                        @if($user_images->count())
                            <table border="1">
                            </table>
                        @else
                            <form action="/profile/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="photo"></label>
                                <input type="file" class="form-control" name="file"accept='image/*' onchange="previewImage(this);">
                                <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
                                    <br>
                                    <br>
                                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
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
                                @foreach($errors->all() as $error)
                                <font color =red>*{{ $error }}</font>
                                @endforeach
                            @endif
                        </div>
                        @if(Auth::user()->id === $user->id)
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
                                    <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                </form>
                            @endif
                        @endif
                        <br>
                </div>
                <!-- class="card" -->
                <p></p>
            </div>

            <div class="col-md-9">
                    <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container" style="
    box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);
">
                <input id="tab1" type="radio" name="tab_item" checked>
                <label class="tab_item" for="tab1"><i class="fas"></i> {{ $user->follows()->count() }} Following</label>
                <input id="tab2" type="radio" name="tab_item">
                    <label class="tab_item" for="tab2"><i class="fas"></i> {{ $user->followUsers()->count() }} Followers</label>
                    <!-- TAB:Following -->
                    <div class="tab_content" id="tab1_content">
                        <div class="tab_content_description">
                            @foreach ($user->follows as $follow)
                            <div class="card">
                                <h5 class="card-header" style="color:#094067;">
                                    <div class="d-flex flex-row">
                                        <div class="p-2">
                                            @if ($follow->images->isEmpty()) 
                                                <a href="/profile/{{$follow->id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                            @else
                                                @foreach($follow->images as $image)
                                                <a href="/profile/{{$follow->id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$follow->id}}"><i class="fas">{{$follow->name}}</i></a>
                                        </div>
                                        <div class="p-2">
                                        <!-- Follow button:Display only in other users' profiles  -->
                                        @if(Auth::user()->id !== $follow->id)
                                            @if($follow->followUsers()->where('following_user_id', Auth::id())->exists())
                                                <form action="{{ route('unfollow', $follow) }}" method="POST">
                                                    @csrf
                                                    <a></a><input type="submit" value="&#xf164; Following" class='fas btn btn-primary'></a>
                                                </form>
                                                @else
                                                <form action="{{ route('follow', $follow) }}" method="POST">
                                                    @csrf
                                                    <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                                </form>
                                            @endif
                                        @endif
                                        </div>
                                    </div>
                                </h5>
                            </div>
                            <p></p>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab_content" id="tab2_content">
                        <div class="tab_content_description">
                        @foreach ($user->followusers as $follow)
                            <div class="card" href="/profile/{{$follow->id}}">
                                <h5 class="card-header" style="color:#094067;" href="/profile/{{$follow->id}}">
                                    <div class="d-flex flex-row">
                                        <div class="p-2">
                                            @if ($follow->images->isEmpty()) 
                                                <a href="/profile/{{$follow->id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                            @else
                                                @foreach($follow->images as $image)
                                                <a href="/profile/{{$follow->id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$follow->id}}"><i class="fas">{{$follow->name}}</i></a>
                                        </div>
                                        <div class="p-2">
                                        <!-- Follow button:Display only in other users' profiles  -->
                                        @if(Auth::user()->id !== $follow->id)
                                            @if($follow->followUsers()->where('following_user_id', Auth::id())->exists())
                                                <form action="{{ route('unfollow', $follow) }}" method="POST">
                                                    @csrf
                                                    <a></a><input type="submit" value="&#xf164; Following" class='fas btn btn-primary'></a>
                                                </form>
                                                @else
                                                <form action="{{ route('follow', $follow) }}" method="POST">
                                                    @csrf
                                                    <input type="submit" value="&#xf164; Follow Me" class="fas btn btn-link">
                                                </form>
                                            @endif
                                        @endif
                                        </div>
                                    </div>
                                </h5>
                            </div>
                            <p></p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- class="col-md-9"」 -->
        </div>
    </div>
    <!-- class="container" -->
@endsection