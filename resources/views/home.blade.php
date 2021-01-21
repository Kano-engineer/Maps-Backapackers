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
        <!-- <h3>新しいピンを作成</h3> -->
            <textarea name="text" placeholder="text"></textarea>
            <button type="submit">ピンを作成</button>
    </form>
</div>

<div class="container">
  @foreach ($pins as $pins)
  <p>・{{ $pins->text }}</p>
  <p><a href="post/{{$pins->id}}">PIN</a></p>
  @endforeach
</div>

@endsection