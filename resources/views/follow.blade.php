@extends('layouts.app')

    <style>
    /* Map Responsive */
    .map_wrapper {
      position: relative; 
      width:100%;
      padding-top:56.25%;
      border: 1px solid #CCC;  
    }
    .map_wrapper .gmap {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    } 

    /*Tab Menu*/
    .tab_container {
        padding-bottom: 1em;
        background-color: #fff;
        border:1px solid #3490dc;
        margin: 0 auto;}
        .tab_item {
        width: calc(100%/2);
        padding:15px 0;
        border-bottom: 3px solid #3490dc ;
        background-color: #ececec;
        text-align: center;
        color: #3490dc ;
        display: block;
        float: left;
        text-align: center;
        font-weight: bold;
        transition: all 0.2s ease;
        }
        .tab_item:hover {
        opacity: 0.75;
        }
        input[name="tab_item"] {
        display: none;
        }
        .tab_content {
        display: none;
        padding: 1em 1em 0;
        clear: both;
        overflow: hidden;
        }
        #tab1:checked ~ #tab1_content,
        #tab2:checked ~ #tab2_content {
        display: block;
        }
        .tab_container input:checked + .tab_item {
        background-color: #3490dc ;
        color: #fff;
        }
    </style>

    @section('content')
    <div class="container">
        <div class="row">

        <div class="col-md-3">
                <div class="card" style="">
                   <!-- User's image -->
                   @if ($user_images->isEmpty()) 
                   <a href="/profile/{{ $user->id }}"><img class="card-img-top" alt="..." style="" src="{{ URL::asset('image/profile.png') }}" /></a>
                    @else
                        @foreach ($user_images as $user_image)
                        <a href="/profile/{{ $user->id }}"><img class="card-img-top" alt="..." style="" src="{{ asset('storage/' . $user_image['file_name']) }}"></a>
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
                    <!-- Upload image-->
                    @if(Auth::user()->id === $user->id)
                        <form action="/profile/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="photo"></label>
                            <input type="file" class="form-control" name="file">
                            <button type="submit"  class='btn btn-primary btn-lg active btn-sm' ><i class="fas fa-images">画像アップロード</i></button>
                        </form>
                    @endif

                    <div class="card-body">
                        <br>
                        <h5><i class="fas fa-user">{{ $user->name }}</i></h5>
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
                        
                        <!-- Profile comment -->
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
                                <input name="comment_profile" placeholder="Self-Introduction">
                                <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                            </form>
                        @endif
                        @foreach ($comments as $comment)
                            <div class="d-flex flex-row">
                                <div class="p-2">
                                    <p class="card-text" style="color:#094067;">{{ $comment ->comment}}</p>   
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
                    </div>
                    <!-- class="card-body" -->
                    <!-- Following / Followers -->
                    <div class="d-flex flex-row">
                            <div class="p-2">
                                <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->follows()->count() }} Following</i></a>
                            </div>
                            <div class="p-2">
                            <a href="/follow/{{$user->id}}" class=".font-weight-bold" style=""><i class="fas">{{ $user->followUsers()->count() }} Followers</i></a>
                            </div>
                    </div>
                    <a href="/map2/" type="button" class="btn btn-primary"><i class="fas fa-search"></i>SEARCH</a>
                </div>
                <!-- class="card" -->
                <p></p>
            </div>

            <div class="col-md-9">
                    <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container">
                <input id="tab1" type="radio" name="tab_item" checked>
                <label class="tab_item" for="tab1"><i class="fas"></i> {{ $user->follows()->count() }} Following</label>
                <input id="tab2" type="radio" name="tab_item">
                    <label class="tab_item" for="tab2"><i class="fas"></i> {{ $user->followUsers()->count() }} Followers</label>
                    <!-- TAB:TIMELINE -->
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
                                        <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$follow->id}}"><i class="fas fa-user">{{$follow->name}}</i></a>
                                    </div>
                                    </div>
                                </h5>

                            </div>
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
                                        <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$follow->id}}"><i class="fas fa-user">{{$follow->name}}</i></a>
                                    </div>
                                    </div>
                                </h5>

                            </div>
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