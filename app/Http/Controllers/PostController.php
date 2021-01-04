<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //todo or diary 作成画面を表示
    public function index(){
        return view('post.todo_daily_index');
    }
    
    //DBに登録し、投稿完了画面へ
    public function post(Request $request){
        $user = Auth::user();

        //todoがpostされた時
        if($request->has('todo')){
            $todoPost = $request->all();
            Post::create($todoPost);
            return view('post.send');
            
        //diaryがpostされた時
        }elseif($request->has('daily')){
            $diaryPost = $request->all();
            Post::create($diaryPost);
            return view('post.send');
        };
    }

    //todo or diary 作成完了画面を表示
    public function send(){
        return view('post.send');
    }

    //タイムライン画面を表示
    public function showTimeline(){
        $posts=Post::all();

        return view('post.timeline',['posts' => $posts],);
    }


    //timelineのコメント画面を表示
    public function showComment($id){
        //timelineのpostから詳細投稿を取得
        $post=Post::find($id);

        //投稿者を判別するためのリレーション処理
        $user_name = Post::find($id)->user->name;

        //コメントを全て取ってくる
        $comments=Comment::all();

        //withメソッドで値をviewへ返す
        return view('post.comment',['post' => $post],['comments' => $comments])->with('user_name',$user_name);
    }


    //timelineのコメントを投稿
    public function postComment(Request $request_comment)
    {
       //データを受け取る
        $input = $request_comment->all();
  
        Comment::create($input);

        return redirect(route('showComment'));
    }


    
}