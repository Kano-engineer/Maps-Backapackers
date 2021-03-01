@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <!-- TODO:Use @yield('sidebar') instead of <div class="sidebar">-->
                        <div class="sidebar">
                        <!-- 2/28 Update:sidebar in card -->
                            <div class="card" style="width:;">
                                @if (Auth::user()->images->isEmpty()) 
                                    <a href="/profile"><img style="" src="{{ URL::asset('image/4.jpg') }}"  class="card-img-top" alt="..."></a>
                                @else
                                    @foreach(Auth::user()->images as $image)
                                    <a href="/profile"><img style="" src="{{ asset('storage/' . $image['file_name']) }}" class="card-img-top" alt="..."></a>
                                    @endforeach
                                @endif
                                <a href="/profile" class="card-body">
                                <h4><i class="fas fa-user">USER：</i>{{ Auth::user()->name }}</h4>
                                    @foreach ($comment as $comment)
                                    <p class="card-text">{{ $comment ->comment}}</p>
                                    @endforeach
                                </a>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><a href="/map"><i class="fas fa-globe-europe">MAPで検索(実装中：クリックOK)</i></a></li>
                                    <li class="list-group-item"><a href="/post"><i class="fas fa-comment-dots">共有チャット/タイムライン</i></a></li>
                                </ul>
                            </div>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="app">
                            <example-component></example-component>
                        </div>
                    </div>
                </div>
            </div>
            @endsection