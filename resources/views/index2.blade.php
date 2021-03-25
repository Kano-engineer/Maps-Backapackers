@extends('layouts.app')

@section('content')
<h1>検索</h1>
 
<form action="{{url('/books')}}" method="GET">
    <p><input type="text" name="keyword" value=""></p>
    <p><input type="submit" value="検索"></p>
</form>

@if($pins->count())
<table border="1">
    <tr>
        <th>Place</th>
        <th></th>
        <th></th>
    </tr>
    @foreach ($pins as $pins)
    <tr>
        <td>{{ $pins->text }}</td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</table>
 
@else
<p>PLACE：０</p>
@endif

<br>

@if($user->count())
<table border="1">
    <tr>
        <th>USER</th>
        <th></th>
        <th></th>
    </tr>
    @foreach ($user as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</table>
 
@else
<p>USER：０</p>
@endif

@endsection