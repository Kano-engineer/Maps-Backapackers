@extends('layouts.app')

@include('common.aside')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                    <p><a href="home/myprofile">マイページへ</a<></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
  <p>task</p>
</div>
<div class="row justify-content-center">
<a href="{{action('PostController@index')}}">
    <button class="btn btn-danger" type="submit">newpost</button>
</a>
</div>
<div class="row justify-content-center">
<p>daily</p>
</div>
<div class="row justify-content-center">
    <a href="{{action('BookmarkController@index')}}">
        <button class="btn btn-danger" type="submit">bookmark</button>
    </a>
</div>

<div class="row justify-content-center">
  <a href="/post/timeline">
      <button class="btn btn-danger" type="submit">みんなの投稿へ</button>
  </a>
</div>
@endsection


