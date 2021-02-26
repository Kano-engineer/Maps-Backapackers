@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
            <ul class="navbar-nav mr-auto">
                <div class="sidebar">
                    <div class="sidebar-item">
                    <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                        @if (Auth::user()->images->isEmpty()) 
                            <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                        @else
                            @foreach(Auth::user()->images as $image)
                            <img style="width:250px;height:200px;" src="{{ asset('storage/' . $image['file_name']) }}">
                            @endforeach
                        @endif
                            <p><a href="/profile" class="btn btn-primary"><i class="fas fa-user"></i>My Profile</a></p>
                        <div class="btn-sidebar">
                            <a type="button" class="btn btn-primary btn-sm" href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a>
                            <br>
                            <p></p>
                            <a type="button" class="btn btn-primary btn-sm" href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                            <p></p>
                            <br>
                        </div>
                    </div>
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
            <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">地名/住所を入力して旅をシェアしよう</i></h5>
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
                    <div class="card-body">
                        @if ($pins->photos->isEmpty()) 
                                <img style="width:250px;height:200px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
                        @else
                                @foreach($pins->photos as $photo)
                                <img style="width:250px;height:200px;" src="{{ asset('storage/' . $photo['photo']) }}">
                                @endforeach
                        @endif
                            <p class="card-text"></p>
                            <a href="post/{{$pins->id}}" class="btn btn-primary"><i class="fas fa-globe-europe">MAPを見る</i></a>
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
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>
@endsection