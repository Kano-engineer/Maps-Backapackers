@extends('layouts.app')

@section('content')
<h1>検索</h1>
 
<form action="{{url('/books')}}" method="GET">
    <p><input type="text" name="keyword" value=""></p>
    <p><input type="submit" value="検索"></p>
</form>

@endsection