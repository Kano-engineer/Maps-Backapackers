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


    //プロフィール画面から画像をアップ
    public function storeMyImg(Request $request)
    {
        //画像ファイルに名前をつけて指定ディレクトリに保存、変数に代入
        //postで受け取ったデータ（$request）の中にある myPic(ネーム属性)を、第二引数”ユーザーid＋日付.jpg”の名前で第一引数のディレクトリに保存
        $filepath = $request->myPic->storeAs('public/profile_images', Auth::id() . date("YmdHis"). '.jpg');
        
        //ユーザーIDからユーザー情報を取得、変数に代入
        $user = User::find(auth()->id());

        //ユーザー情報からmy_picカラムのデータをピックアップし、
        //$filepathのファイル名の部分のみをmy_picカラムに代入
        $user->my_pic = basename($filepath);

        //保存
        $user->save();

        //ルート名 showMypage へ移動。フラッシュメッセージのデータも一緒に。
        return redirect()->route('showMyProfile')->with('success', '新しいプロフィールを登録しました');

        //return view('myprofile');
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
