@extends('layouts.app')

@section('content')
@if ($errors->has('text'))
<ul>
    @foreach($errors->all() as $error)
        <!-- <li>{{ $error }}</li> -->
        <font color =red>*{{ $error }}</font>
    @endforeach
</ul>
@endif
<form action="/update/{{$pin->id}}" method="post">
            @csrf
            <p>PIN:{{$pin->text}}</p>
            <input type="text" name="text" value="{{$pin->text}}">
            <input type="submit" value="更新">
</form>
@endsection