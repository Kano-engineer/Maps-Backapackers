@extends('layouts.app')

@include('common.aside')

@section('content')
    <a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>


 <div class="row justify-content-center">
   <p>みんなの投稿</p>
 </div>

 <div class="">
      @foreach ( $posts as $post )
        @if( $post -> diary  === NULL)
            <div class="row justify-content-center">
              <p class="">todo:{{ $post -> todo }}</p>
              <p class=""><a href="/post/comment/{{ $post -> id }}">コメント</a></p>
            </div>
        @else( $post -> todo  === NULL)
            <div class="row justify-content-center">
              <p class="">diary:{{ $post -> diary }}</p>
              <p class=""><a href="/post/comment/{{ $post -> id }}">コメント</a></p>
            </div>
        @endif
      @endforeach
     
 </div>

@endsection