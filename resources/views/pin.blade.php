@extends('layouts.app')

@section('content')
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<a href="/home">HOME</a>
<!-- 画像アップロード -->
<form action="/store/{{$pin->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo">画像アップロード:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit">
</form>

<p>{{optional($pin) -> text}}</p>
@foreach ($photos as $photo)
        <img src="{{ asset('storage/' . $photo['photo']) }}">
        <br>
    @endforeach

@endsection