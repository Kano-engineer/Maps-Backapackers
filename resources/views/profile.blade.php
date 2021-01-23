@extends('layouts.app')
<title>My Profile</title>

@section('content')
    <h1>My Profile：{{ $user->name }}</h1>

    <div>
@if ($errors->any())
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
   </div>


@if(Auth::user()->id === $user->id)
<form action="profile/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo">プロフィール画像アップロード:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit">
</form>
@endif

<br>
@foreach ($user_images as $user_image)
    <img src="{{ asset('storage/' . $user_image['file_name']) }}">
    <br>

    <!-- 写真削除 idで判別-->
    <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                @csrf
                @method('DELETE')
                @if(Auth::user()->id === $user->id)
                <input type="submit" value="削除" onClick="delete_alert(event);return false;">
                @endif
    </form>
@endforeach

<div class="container">
    @foreach ($pin as $pin)
        <p>▼<a style="color:blue;" href="post/{{$pin->id}}">PIN</a>：{{ $pin->text }}</p>
        <p></p>
    @endforeach
</div>


    <script src="{{ asset('/js/alert.js') }}"></script>

@endsection