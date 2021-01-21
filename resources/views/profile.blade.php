@extends('layouts.app')
<title>My Profile</title>

@section('content')
    <h1>My Profile</h1>

    <div>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
    @foreach($errors->all() as $error)
    <font color =red>*{{ $error }}</font>
    @endforeach
@endif
</div>

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

        <!-- 写真削除 idで判別-->
        <form action="{{ action('ProfileController@destroy', $user_image->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onClick="delete_alert(event);return false;">
        </form>
    @endforeach

    <script src="{{ asset('/js/alert.js') }}"></script>

@endsection