@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
            <ul class="navbar-nav mr-auto">
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
                        <a href="/profile" class="card-body">
                        <h4><i class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                            @foreach ($comments as $comment)
                               <p class="card-text">{{ $comment ->comment}}</p>
                            @endforeach
                        </a>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a></li>
                            <li class="list-group-item"><a href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a></li>
                        </ul>
                        </div>
                        <p></p>
                </div>
            </ul>
        </div>

        <div class="col-md-8">
            @if ($errors->has('text'))
                <ul>
                    @foreach($errors->all() as $error)
                        <font color =red>*{{ $error }}</font>
                    @endforeach
                </ul>
            @endif
            <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">あなたの旅をシェアしよう</i></h5>
                <form action="/post" method="post" class=".form-control:focus">
                    {{ csrf_field() }}
                    <input type="search" name="text" placeholder="地名/住所">
                    <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
                </form>
        <br>
            <!-- TODO:Use tab menu for switching between list and map -->
            @foreach ($pins as $pins)
                <div class="card">
                        <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default btn-sm" style="color:#3da9fc;" href="profile/{{$pins->user_id}}"><i class="fas fa-user"></i> {{$pins->user->name}}</a>：{{ $pins->text }}</h5>
                    <a href="post/{{$pins->id}}" class="card-body">
                        @if ($pins->photos->isEmpty()) 
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                        @else
                                @foreach($pins->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                        @endif
                            <p class="card-text"></p>
                            <!-- <div class="d-flex flex-row">
                                <div class="p-2">
                                    <a href="post/{{$pins->id}}" class="btn btn-primary"><i class="fas fa-globe-europe">MAPを見る</i></a>
                                </div>
                                <div class="p-2"> -->
                                    @if($pins->users()->where('user_id', Auth::id())->exists())
                                        <form action="{{ route('unfavorites', $pins) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164;Like {{ $pins->users()->count() }}" class="fas btn btn-primary">
                                        </form>
                                    @else
                                        <form action="{{ route('favorites', $pins) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="&#xf164;Like {{ $pins->users()->count() }}" class="fas btn btn-link">
                                        </form>
                                    @endif
                                <!-- </div>
                            </div> -->
                    </a>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>
@endsection