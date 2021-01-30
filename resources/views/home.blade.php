@extends('layouts.app')

@section('content')

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="links">

<div class="container">
<div class="row">
    <div class="col-xs-6 col-md-4"></div>
    <div class="col-xs-6 col-md-4">
        <!-- エラーメッセージ。なければ表示しない -->
        @if ($errors->has('text'))
        <ul>
        @foreach($errors->all() as $error)
            <font color =red>*{{ $error }}</font>
        @endforeach
        </ul>
        @endif
    <p class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">地名/住所を入力して旅をシェアしよう</i></p>
    <form action="/post" method="post" class=".form-control:focus">
        {{ csrf_field() }}
        <input type="search" name="text" placeholder="地名/住所">
        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
    </form>
    </div>
    <div class="col-xs-6 col-md-4"></div>
    </div>
</div>

<br>
<!-- <i class="far fa-heart"></i> -->
<!-- class=" :focus" -->

<div class="container">
    <div class="row">
    <div class="col-xs-6 col-md-4"></div>
    <div class="col-xs-6 col-md-4">
    @foreach ($pins as $pins)
        <p><a type="button"  style="color:#3da9fc;" href="post/{{$pins->id}}"><i class="fas fa-map-marker-alt"></i></a> 
        <a style="color:#094067;">{{ $pins->text }} by</a><a type="button" class="btn btn-default btn-sm" style="color:#3da9fc;" href="profile/{{$pins->user_id}}"><i class="fas fa-user"></i> {{$pins->user->name}}</a></p>
    @endforeach
    </div>
    <div class="col-xs-6 col-md-4"></div>
    </div>
</div>

<div class="container">
    <div class="row">
    <div class="col-xs-6 col-md-4"></div>
    <div class="col-xs-6 col-md-4">
<a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
    </div>
    <div class="col-xs-6 col-md-4"></div>
    </div>
</div>

@endsection