@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <!-- 3/1 Update:sidebar in card -->
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
        <div class="col-md-8">
            @if ($errors->has('text'))
                <ul>
                    @foreach($errors->all() as $error)
                        <font color =red>*{{ $error }}</font>
                    @endforeach
                </ul>
            @endif
            <form action="/update/{{$pin->id}}" method="post" class=".form-control:focus">
                @csrf
                <h5 class=".font-weight-bold" style="color:#094067;"><i class="fas fa-map-marker-alt">{{optional($pin) -> text}} by </i><a style="color:#3da9fc;" href="/profile/{{$pin->user_id}}"><i class="fas fa-user"></i>{{$pin->user->name}}</a></h5>
                    <input type="text" name="text" value="{{$pin->text}}">
                    <input class="btn btn-primary btn-lg active btn-sm" type="submit" value="EDIT">
            </form>
        </div>
    </div>
</div>
@endsection