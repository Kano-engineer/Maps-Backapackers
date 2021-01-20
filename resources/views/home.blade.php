@extends('layouts.app')

@section('content')
<div class="container">
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
</div>

<div>
    <form action="/post" method="post">
        {{ csrf_field() }}
        <!-- <h3>新しいピンを作成</h3> -->
            <textarea name="text" placeholder="text"></textarea>
            <button type="submit">ピンを作成</button>
    </form>
</div>

<div class="container">
  @foreach ($pins as $pins)
  <p>{{ $pins->text }}</p>
  <p><a href="post/{{$pins->id}}">PIN</a></p>
  @endforeach
</div>

<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<!-- 画像アップロード -->
<a href="/output">プロフィール</a>
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo">画像アップロード:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit">
</form>

@endsection