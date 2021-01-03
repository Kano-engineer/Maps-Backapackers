@include('common.head')
@include('common.navbar')
@section('title','投稿')
    <a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                    <h1>OK!送信できました！</h1>
                     <a href="/post/timeline">タイムラインで確認！</a>
                     
            </div>
</div>
</div>
</div>