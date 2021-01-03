@include('common.head')
@include('common.navbar')
@section('title','目標')
    <a href="{{action('HomeController@index')}}">
        <button class="btn btn-danger" type="submit">jikoken</button>
    </a>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('target') }}</div>
                <div class="card-body">
                <form method="post" action="{{ url('/post/send')}}">
                    {{ csrf_field() }}
                    <h1>目標を作りましょう</h1>
                    <p>こんなふうに書いてみて</p>
                    <p>Big:車を買う。</p>
                    <p>Middle:就職する。</p>
                    <textarea name="target" placeholder=""></textarea>
                    </p>
                        <button class="btn btn-primary" name="big" type="submit">BIG</button>
                        <button class="btn btn-danger" name="middle" type="submit">MIDDLE</button>
                    </p>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

