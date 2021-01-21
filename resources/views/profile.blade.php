@extends('layouts.app')

@section('content')
    <a href="/home">HOME</a>
    <h1>My Profile</h1>
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo">プロフィール画像アップロード:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit">
</form>
    <br>
    @foreach ($user_images as $user_image)
        <img src="{{ asset('storage/' . $user_image['file_name']) }}">
        <br>
    @endforeach

@endsection