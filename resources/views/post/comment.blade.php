@extends('layouts.app')

@include('common.aside')

@section('content')

 <div class="row justify-content-center">
   <p>
        @if( $post -> diary  === NULL)
            <div class="row justify-content-center">
              <p class="">todo:{{ $post -> todo }}</p>
              <p class=""><a href="/userprofile/{{ $post -> id }}">投稿者:　{{ $user_name }}</a></p>
            </div>
        @else
            <div class="row justify-content-center">
              <p class="">diary:{{ $post -> diary }}</p>
            </div>
        @endif
    </p>
 </div>

 <div class="">
           @foreach ( $comments as $comment )
             @if( $comment -> post_id ===  $post -> id )
               <p class="row justify-content-center">{{ $comment -> comment }}</p>
             @endif
           @endforeach
　</div>

 <div class="row justify-content-center">
　　　　　
        <div class="card">
            <div class="card-body">
                <form method="post" >
                    {{ csrf_field() }}
                     <p>コメントを書く</p>
                     <textarea name="comment" placeholder=""></textarea>
                         <p><input class="btn btn-primary" name="todo" type="submit" value="コメントする！"></p>
                </form>
        </div>

</div>
</div>


@endsection