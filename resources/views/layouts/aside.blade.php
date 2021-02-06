
@section('aside')
@if ( Auth::check() )
                    <ul class="navbar-nav mr-auto">
                        <div class="sidebar">
                            <div class="sidebar-item">
                                <h2>{{ Auth::user()->name }}</h2>
                                    <p><a href="/home/myprofile" class="a-sky">登録情報</a></p>
                                <div class="btn-sidebar">
                                    <a href="/post/timeline" class="btn btn-sky btn-block">タイムライン</a>
                                    <a href="" class="btn btn-sky btn-block">マイページ</a>
                                    <a href="" class="btn btn-sky btn-block">目標を投稿</a>
                                    <a href="" class="btn btn-sky btn-block">TODO/日記を投稿</a>
                                </div>
                            </div>
                        </div>
                    </ul>
@endif
@endsection