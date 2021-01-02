<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(){
        return view('post.todo_daily_index');
    }

    public function send(Request $request)
{

    if($request->has('todo')){

        $output = $request->todo;
        return view('post.todo_daily_index');

    }elseif($request->has('daily')){

        // ここにdailyボタン押下時の処理
    }

}

}
