@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row">
     <div class="col-xs-6 col-md-4">
             <!-- side -->
@if ( Auth::check() )
<ul class="navbar-nav mr-auto">
        <div class="sidebar">
            <div class="sidebar-item">
                <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                    <p><a href="/profile" class="btn btn-primary">MyProfile</a></p>
                <div class="btn-sidebar">

                    <a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                    
                </div>
            </div>
        </div>
    </ul>
@endif
     </div>
     <div class="col-xs-6 col-md-4">
@if ($errors->has('text'))
<ul>
    @foreach($errors->all() as $error)
        <!-- <li>{{ $error }}</li> -->
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
     <div class="col-xs-6 col-md-4"></div>
     </div>
</div>
@endsection