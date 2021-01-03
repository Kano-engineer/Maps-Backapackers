@include('common.head')
@include('common.navbar')
@section('title','ブックマーク')
    <a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('bookmark') }}</div>
            <div class="card-body">
                <form method="post" action="{{ url('/post/send')}}">
                    {{ csrf_field() }}
                    <h1>ブックマーク登録</h1>
                    <ul style="list-style: none;">
                    <li>タイトル<input type="text" name="bookmark"></li>
                    <li>URL　　<input type="text" name="bookmark"></li>
                    <li>説明文　<input type="text" name="bookmark"></li>
                    </ul>
                    </p>
                        <button class="btn btn-primary" name="big" type="submit">保存</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
