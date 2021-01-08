@include('common.head')
@include('common.navbar')
@section('title','投稿')
    <a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('todo_diary') }}</div>
            <div class="card-body">
                <form method="post" action="./">
                    {{ csrf_field() }}
                    <h1>todoとdiaryを作成しましょう</h1>
                     <p>こんなふうに書いてみて</p>
                     <p>TODO:とても面白い本(○章まで)読む。</p>
                     <p>DIARY:お母さんのお手伝いをしました。喜んでいました。</p>
                     <textarea name="todo" placeholder=""></textarea>
                     <input type="hidden" name="todo"  value="{{Auth::user()->id}}">
                         <p><button class="btn btn-primary" name="todo" type="submit">TODOを作成</button></p>
                     <textarea name="diary" placeholder=""></textarea>
                     <input type="hidden" name="diary"  value="{{Auth::user()->id}}">
                         <p><button class="btn btn-danger" name="dairy" type="submit">DIARYを作成</button></p>
                </form>
            </div>
</div>
</div>
</div>
</div>

diary