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
                   <!-- プロフィール画像を表示 -->
                    <img src="{{ asset('storage/profiles/'.Auth::user()->my_pic) }}" alt="プロフィール画像">

                <form method="post" action="">
                    {{ csrf_field() }}
                    <input type="file" name="myPic" class="input-file">
                    <p><button class="btn btn-danger" type="submit">画像を送信</button></p>
                </form>

   　　　　　　　　　　<table class="table table-striped">  
   　　　　　　　　　　　<tr>
   　　　　　　　　　　　　<th>氏名</th>
   　　　　　　　　　　　　<td>{{ Auth::user()->name }}</td>
   　　　　　　　　　　　</tr>  
   　　　　　　　　　　　<tr>
   　　　　　　　　　　　　<th>メールアドレス</th>
   　　　　　　　　　　　　<td>{{ Auth::user()->email }}</td>
   　　　　　　　　　　　</tr>  
   　　　　　　　　　　</table>
   　　　　　　　　　</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
