@extends('layouts.app')

@section('content')
　<a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                 　<h1>プロフィール</h>
                </div>
                <div class="card-body">
                　<div style="margin-top: 30px;">
   　　　　　　　　　　<table class="table table-striped">  
   　　　　　　　　　　　<tr>
   　　　　　　　　　　　　<th>氏名</th>
   　　　　　　　　　　　　<td>{{ $user -> name }}</td>
   　　　　　　　　　　　</tr>  
   　　　　　　　　　　　<tr>
   　　　　　　　　　　　　<th>投稿</th>
                          @foreach ( $posts as $post )
                            @if( $post -> diary  === NULL)
                              <td>todo：{{ $post -> todo }}</td>
                            @else( $post -> todo  === NULL)
                              <td>diary：{{ $post -> diary }}</td>
                            @endif
                          @endforeach
   　　　　　　　　　　　</tr>  
   　　　　　　　　　　</table>
   　　　　　　　　　</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection