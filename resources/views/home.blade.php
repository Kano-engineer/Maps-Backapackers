@extends('layouts.app')



@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4">
 @if ( Auth::check() )
    <ul class="navbar-nav mr-auto">
        <div class="sidebar">
            <div class="sidebar-item">
                <h4><i style="color:#094067;" class="fas fa-user">(写真)USER：</i>{{ Auth::user()->name }}</h4>
                <img style="width:250px;height:200px;" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="...">
                    <p><a href="/profile" class="btn btn-primary">MyProfile</a></p>
                <div class="btn-sidebar">

                    <a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                    <br>
                </div>
            </div>
        </div>
    </ul>
@endif
    </div>
    <div class="col-md-8">
        @if ($errors->has('text'))
        <ul>
        @foreach($errors->all() as $error)
            <font color =red>*{{ $error }}</font>
        @endforeach
        </ul>
        @endif
        <h5 type="button" class="btn btn-primary" href="#"><i class="fas fa-edit">あなたの旅をシェアしよう</i></h5>
    <p class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">地名/住所を入力してあなたの旅をシェアしよう</i></p>
    <form action="/post" method="post" class=".form-control:focus">
        {{ csrf_field() }}
        <input type="search" name="text" placeholder="地名/住所">
        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
    </form>

<br>

@foreach ($pins as $pins)
<div class="card">
  <h5 class="card-header" style="color:#094067;"><a type="button" class="btn btn-default btn-sm" style="color:#3da9fc;" href="profile/{{$pins->user_id}}"><i class="fas fa-user"></i> {{$pins->user->name}}</a>：{{ $pins->text }}</h5>
  <div class="card-body">
    <img style="width:200px;height:150px;" src="{{ URL::asset('image/noimage.png') }}"  class="card-img-top" alt="...">
    <h5 class="card-title">SNS for Backpackers</h5>
    <p class="card-text"></p>
    <a href="post/{{$pins->id}}" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
<br>
@endforeach

<br>
    <!-- <div class="col-md-4">
    </div> -->
    </div>
</div>

@endsection
