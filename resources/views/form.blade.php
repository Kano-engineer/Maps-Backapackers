@extends('layouts.app')
<style>
    /* Responsive */
    .map_wrapper {
      position: relative; 
      width:100%;
      padding-top:56.25%;
      border: 1px solid #CCC;  
    }
    .map_wrapper .gmap {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    } 
    </style>

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-3">
            <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                <div class="sidebar">
                <!-- 2/28 Update:sidebar in card -->
                    <div class="card" style="width:;">
                        @if (Auth::user()->images->isEmpty()) 
                            <a href="/profile"><img style="" src="{{ URL::asset('image/profile.png') }}"  class="card-img-top" alt="..."></a>
                        @else
                            @foreach(Auth::user()->images as $image)
                            <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                            @endforeach
                        @endif
                            <p></p>
                            <a href="/profile" type="button" class="btn btn-primary"><i class="fas fa-user">{{ Auth::user()->name }}</i></a>
                            <p></p>
                            <a href="/map" type="button" class="btn btn-primary"><i class="fas fa-globe-europe">MAP</i></a>
                            <p></p>
                            <a href="/post" type="button" class="btn btn-primary"><i class="fas fa-comment-dots">TALK</i></a>
                    </div>
                    <p></p>
                </div>
        </div>
        <div class="col-md-9">
            @if ($errors->has('text'))
                <ul>
                @foreach($errors->all() as $error)
                    <font color =red>*{{ $error }}</font>
                @endforeach
                </ul>
            @endif
            <form action="/post" method="POST" class=".form-control:focus" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="card">
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
                                    <a type="button" class="btn btn-default" style="color:#3da9fc;" href="/profile/{{Auth::user()->user_id}}"><i class="fas fa-user">{{Auth::user()->name}}</i></a><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="p-2">
                                    <input class="form-control" name="text"  id="address" placeholder="例：「あなたの地元」">
                                </div>
                                <div class="p-2">
                                    <small><font color =red>*必須</font></small>
                                </div>
                            </div>
                        </h5>
                            <div class="card-body">
                                <textarea class="form-control" name="body"  placeholder="とっておきの「ローカル」な情報をシェアしよう！：「ここの景色が綺麗」、「地元の人しか知らないお店」" rows="5"></textarea>
                            <p class="card-text"></p>
                                <label><i class="fas fa-images"></i>Photos</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                    </div>
                        <div class="map_wrapper">
                            <div id="gmap" class="gmap"></div>
                        </div>
                    <br>
                        <button type="submit" class="btn btn-primary" style="width:100%;padding:0px;font-size:30px;border-radius:20px 20px 20px 20px;"><i class="fas fa-edit">Share Your Travel</i></button>            
                </div> 
            </form>
        </div>
    </div>
</div>

<script>
  function initMap() {
    var target = document.getElementById('gmap');  
    //Show map
    var map = new google.maps.Map(target, {  
      center: { lat: 35.6585, lng: 139.7486 },
      zoom: 4
    });
    //Make instance of geocording
    var geocoder = new google.maps.Geocoder();  
    
    map.addListener('click', function(e){
      //reverse geodcording
      geocoder.geocode({location: e.latLng}, function(results, status){
        if(status === 'OK' && results[0]) {

          var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,
            title: results[0].formatted_address,
            animation: google.maps.Animation.DROP
          });
          
          var infoWindow = new google.maps.InfoWindow({
            content:  results[0].formatted_address,
            pixelOffset: new google.maps.Size(0, 5)
          });

          document.getElementById('address').value=results[0].formatted_address;
          
          marker.addListener('click', function(){
            infoWindow.open(map, marker);
            document.getElementById('address').value=results[0].formatted_address;
          });

          //Delete marker 
          infoWindow.addListener('closeclick', function(){
            marker.setMap(null);
          });
        }else if(status === 'ZERO_RESULTS') {
          alert('不明なアドレスです： ' + status);
          return;
        }else{
          alert('失敗しました： ' + status);
          return;
        }
      });
    });
  } 
</script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>
@endsection
