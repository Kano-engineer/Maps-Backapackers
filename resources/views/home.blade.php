@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                    <div class="card" style="width:;">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="/profile"><i class="fas fa-user">USER：{{ Auth::user()->name }}</i></a></li>
                            <li class="list-group-item"><a href="/map"><i class="fas fa-globe-europe">MAP SEARCH(実装中：クリックOK)</i></a></li>
                            <li class="list-group-item"><a href="/post"><i class="fas fa-comment-dots">TALK SPACE</i></a></li>
                        </ul>
                    </div>
                    <p></p>
                </div>
        </div>

        <div class="col-md-8">
            <!-- Update:Use tab menu for switching between list and likes -->
            <div class="tab_container">
            <input id="tab1" type="radio" name="tab_item" checked>
            <label class="tab_item" for="tab1">TIMELINE</label>
            <input id="tab2" type="radio" name="tab_item">
            <label class="tab_item" for="tab2">LIKES</label>
            <!-- TAB:TIMELINE -->
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
                    <!-- TIMELINE -->
                    @foreach ($pins as $pins)
                    <div class="card">
                            <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pins->user_id}}"><i class="fas fa-user">{{$pins->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pins->text }}</i></h5>
                        <a href="post/{{$pins->id}}" class="card-body">
                            @if ($pins->photos->isEmpty()) 
                                    <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                            @else
                                    @foreach($pins->photos as $photo)
                                    <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                    @endforeach
                            @endif
                                <p class="card-text"></p>
                            @if($pins->users()->where('user_id', Auth::id())->exists())
                                <form action="{{ route('unfavorites', $pins) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="&#xf164; LIKE！ {{ $pins->users()->count() }}" class="fas btn btn-primary">
                                </form>
                            @else
                                <form action="{{ route('favorites', $pins) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="&#xf164; LIKE！ {{ $pins->users()->count() }}" class="fas btn btn-link">
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
                                <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pins->user_id}}"><i class="fas fa-user">{{$favorite->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $favorite->text }}</i></h5>
                            <a href="post/{{$favorite->id}}" class="card-body">
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
        </div>
    </div>
</div>
@endsection