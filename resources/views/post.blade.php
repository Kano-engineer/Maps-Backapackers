@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                        <div class="sidebar">
                        <!-- 3/1 Update:sidebar in card -->
                            <div class="card" style="width:;">
                                @if (Auth::user()->images->isEmpty()) 
                                    <a href="/profile"><img style="" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="..."></a>
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
                        <div id="app">
                            <example-component></example-component>
                        </div>
                    </div>
                </div>
            </div>
            @endsection