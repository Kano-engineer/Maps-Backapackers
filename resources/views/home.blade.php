@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                    <div class="card" style="width:;">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                            <p></p>
                            <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user">{{ Auth::user()->name }}</i></a>
                            <p></p>
                            <a href="/map" type="button" class="btn btn-primary"><i class="fas fa-globe-europe">MAP</i></a>
                            <p></p>
                            <a href="/post" type="button" class="btn btn-primary"><i class="fas fa-comment-dots">TALK</i></a>
                    </div>
                    <p></p>
                </div>
        </div>

        <div class="col-md-9">
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
                    <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                    <br>
                    <br>
                    <!-- TIMELINE -->
                    @foreach ($pins as $pins)
                    <div class="card">
                        <h5 class="card-header" style="color:#094067;">
                            <div class="d-flex flex-row">
                            <div class="p-2">
                                @if ($pins->user->images->isEmpty()) 
                                    <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                @else
                                    @foreach($pins->user->images as $image)
                                    <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="p-2">
                                <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$pins->user_id}}"><i class="fas fa-user">{{$pins->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $pins->text }}</i>
                            </div>
                            </div>
                        </h5>
                        <a href="/post/{{$pins->id}}" class="card-body">
                            <p class="card-text" style="color:black;">{{ $pins->created_at}}</p>
                            <p class="card-text" style="color:black;">{{ $pins->body}}</p>
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
                    <a type="button" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;" href="/form"><i class="fas fa-edit">Share Your Travel</i></a>
                    <br>
                    <br>
                    <!-- LIKES -->
                    @foreach ($user->favorites as $favorite)
                        <div class="card">
                            <h5 class="card-header" style="color:#094067;">
                                <div class="d-flex flex-row">
                                <div class="p-2">
                                    @if ($favorite->user->images->isEmpty()) 
                                        <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                    @else
                                        @foreach($favorite->user->images as $image)
                                        <a href="/profile/{{$pins->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2">
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{$favorite->user_id}}"><i class="fas fa-user">{{$favorite->user->name}}</i></a><i class="fas fa-map-marker-alt">{{ $favorite->text }}</i>
                                </div>
                                </div>
                            </h5>
                            <a href="/post/{{$favorite->id}}" class="card-body">
                                <p class="card-text" style="color:black;">{{ $favorite->created_at}}</p>
                                <p class="card-text" style="color:black;">{{ $favorite->body}}</p>
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