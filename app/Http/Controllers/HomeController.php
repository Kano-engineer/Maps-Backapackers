<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     *
     */
    public function push()
    {
        return view('push');
    }

    //プロフィール画面を表示
    public function showMyProfile()
    {
        return view('myprofile');
    }

    //ユーザープロフィール画面を表示
    public function showUserProfile($id)
    {
        //投稿者を判別するためのリレーション処理
        $user = Post::find($id)->user;
        
        $user_id = Post::find($id)->user->id;
        $posts = Post::where('user_id', $user_id)->get();

        return view('userprofile',['user' => $user],['posts' => $posts]);
    }
}
