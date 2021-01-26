@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row">
     <div class="col-xs-6 col-md-4"></div>
     <div class="col-xs-6 col-md-4">
@if ($errors->has('text'))
<ul>
    @foreach($errors->all() as $error)
        <!-- <li>{{ $error }}</li> -->
        <font color =red>*{{ $error }}</font>
    @endforeach
</ul>
@endif
<form action="/update/{{$pin->id}}" method="post" class=".form-control:focus">
            @csrf
            <p><i style="color:#094067;" class="fas fa-map-marker-alt"></i>{{$pin->text}}</p>
            <input type="text" name="text" value="{{$pin->text}}">
            <input class="btn btn-primary btn-lg active btn-sm" type="submit" value="EDIT">
</form>
     </div>
     <div class="col-xs-6 col-md-4"></div>
     </div>
</div>
@endsection