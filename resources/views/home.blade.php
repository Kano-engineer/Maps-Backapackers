@extends('layouts.app')



@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4">
 @if ( Auth::check() )
    <ul class="navbar-nav mr-auto">
        <div class="sidebar">
            <div class="sidebar-item">
                <h4><i style="color:#094067;" class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                    <p><a href="/profile" class="btn btn-primary">MyProfile</a></p>
                <div class="btn-sidebar">

                    <a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a>
                    
                </div>
            </div>
        </div>
    </ul>
@endif
    </div>
    <div class="col-md-4">
        @if ($errors->has('text'))
        <ul>
        @foreach($errors->all() as $error)
            <font color =red>*{{ $error }}</font>
        @endforeach
        </ul>
        @endif
    <p class=".font-weight-bold" style="color:#094067;"><i class="fas fa-edit">地名/住所を入力してあなたの旅をシェアしよう</i></p>
    <form action="/post" method="post" class=".form-control:focus">
        {{ csrf_field() }}
        <input type="search" name="text" placeholder="地名/住所">
        <button class="btn btn-primary btn-lg active btn-sm" type="submit"><i class="fas fa-edit"></i></button>
    </form>

<br>


<table class="table">
    <thead>
        <tr>
            <th>詳細</th>
            <th>地名/住所</th>
            <th>投稿ユーザー</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach ($pins as $pins)
        <tr>
            <th scope="row"><a type="button"  style="color:#3da9fc;" href="post/{{$pins->id}}"><i class="fas fa-globe-europe"></i></a> </th>
            <td><a style="color:#094067;">{{ $pins->text }}</a></td>
            <td><a type="button" class="btn btn-default btn-sm" style="color:#3da9fc;" href="profile/{{$pins->user_id}}"><i class="fas fa-user"></i> {{$pins->user->name}}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- 
<a type="button" class="btn btn-primary btn-lg active btn-sm" href="post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a> -->

<br>
    <div class="col-md-4">
    </div>
    </div>
</div>

@endsection
