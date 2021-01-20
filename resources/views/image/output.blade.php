@extends('layouts.app')

@section('content')
    <a href="/home">ホームに戻る</a>
    <br>
    @foreach ($user_images as $user_image)
        <img src="{{ asset('storage/' . $user_image['file_name']) }}">
        <br>
    @endforeach

@endsection