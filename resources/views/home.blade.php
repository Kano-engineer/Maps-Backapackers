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

<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
        <!-- <li>{{ $error }}</li> -->
        <font color =red>*{{ $error }}</font>
    @endforeach
</ul>
@endif

<div>
    <form action="/post" method="post">
        {{ csrf_field() }}
        <input type="search" name="text" placeholder="地名/住所">
        <button type="submit">ピンを作成</button>
    </form>
</div>

<br>

<div class="container">
    @foreach ($pins as $pins)
        <p>▼<a style="color:blue;" href="post/{{$pins->id}}">PIN</a>：{{ $pins->text }} by <a style="color:blue;" href="profile/{{$pins->user_id}}">{{$pins->user->name}}</a></p>
    @endforeach
</div>

<div class="container">
<p><a style="color:blue;" href="chat">◆共有チャット◆</a></p>
</div>

@endsection