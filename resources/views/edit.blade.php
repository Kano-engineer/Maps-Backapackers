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
            <form action="/update/{{$pin->id}}" method="post" class=".form-control:focus">
                @csrf
                    <p><i style="color:#094067;" class="fas fa-map-marker-alt"></i>{{$pin->text}}</p>
                    <input type="text" name="text" value="{{$pin->text}}">
                    <input class="btn btn-primary btn-lg active btn-sm" type="submit" value="EDIT">
            </form>
        </div>
    </div>
</div>
@endsection