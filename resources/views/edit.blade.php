@extends('layouts.app')

@section('content')
<form action="/update/{{$pin->id}}" method="post">
            @csrf
            <p>PIN:{{$pin->text}}</p>
            <input type="text" name="text" value="{{$pin->text}}">
            <input type="submit" value="更新">
</form>
@endsection