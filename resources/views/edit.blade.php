@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <!-- 3/1 Update:sidebar in card -->
                <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%);
">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="border-radius: 50%;" src="{{ $image['path'] }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                        <br>
                        <h5 style="font-weight: bold; font-size: xxx-large; text-align: center;">{{ Auth::user()->name }}</h5>
                        <!-- <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user"> {{ Auth::user()->name }}</i></a>
                        <p></p> -->
                        <!-- <a href="/post/" type="button" class="btn btn-primary"><i class="fas fa-comment-dots"></i>TALK</a>
                        <p></p> -->
                        <a style="margin-right:8px;margin-left:8px;" href="/index/" type="button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</a>
                        <br>
                </div>
            <p></p>
        </div>
        <div class="col-md-9">
            @if ($errors->has('text'))
                <ul>
                    <font color =red>*{{$errors->first('text')}}</font>
                </ul>
            @endif
            <form action="/update/{{$pin->id}}" method="POST" class=".form-control:focus" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="card" style="box-shadow: 0 2.5rem 2rem -2rem hsl(200 50% 20% / 40%;">
                        <h5 class="card-header" style="color:#094067;">
                            <div class="d-flex flex-row">
                                <div class="p-2">
                                    @if (Auth::user()->images->isEmpty()) 
                                        <a href="/profile/{{Auth::user()->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                                    @else
                                        @foreach(Auth::user()->images as $image)
                                        <a href="/profile/{{Auth::user()->user_id}}"><img style="width:40px;height:40px;border-radius: 50%;" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2"> 
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{Auth::user()->user_id}}"><i class="fas">{{Auth::user()->name}}</i></a><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="p-2">
                                        <input class="form-control" name="text"  placeholder="{{$pin->text}}" value="{{$pin->text}}">
                                </div>
                                <div class="p-2">
                                    <small><font color =red>*必須</font></small>
                                </div>
                            </div>
                        </h5>
                            <div class="card-body">
                                <textarea class="form-control" name="body"  placeholder="{{ $pin->body}}" rows="5">{{$pin->body}}</textarea>
                                <p class="card-text"></p>
                                    <label style="color:#3490dc"><i class="fas fa-images"></i>Photos</label>
                                    <input type="file" name="file" class="form-control" accept='image/*' onchange="previewImage(this);">
                                    <br>
                                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:300px;">
                                    <br>
                                    <br>
                            </div>
                    </div>
                    <br>
                        <button type="submit" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;"><i class="fas fa-user-edit">EDIT</i></button>            
                </div> 
            </form>
            <!--  -->
        </div>
    </div>
</div>

<script>
function previewImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function() {
		document.getElementById('preview').src = fileReader.result;
	});
	fileReader.readAsDataURL(obj.files[0]);
}
</script>
@endsection