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
    <form method="post" action="">
        {{ csrf_field() }}
        <h3>新しいピンを作成</h3>
            <ul>
                <li>ex:景色が綺麗</li>
            </ul>
                <textarea name="todo" placeholder="text"></textarea>
                <input type="hidden" name="user_id"  value="{{Auth::user()->id}}">
                <p><button class="" type="submit">PIN</button></p>
    </form>
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
<form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">
    <!-- アップロードした画像。なければ表示しない -->
    @isset ($filename)
    <div>
        <img src="{{ asset('storage/' . $filename) }}">
    </div>
    @endisset

    <label for="photo">Photo</label>
    <input type="file" class="form-control" name="file">
    <br>
    <hr>
    {{ csrf_field() }}
    <button class="btn btn-success"> Upload </button>
</form>

@endsection