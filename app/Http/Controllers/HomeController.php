<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



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
    public function storeMyImg(Request $request, User $user)
    {
        $uploadfile = $request->file('my_pic');
      if(!empty($uploadfile)){
        $my_picName = $request->file('my_pic')->hashName();
        //storeAsでpublic/profileImgディレクトリにランダム名で画像を格納
        $request->file('my_pic')->storeAs('public/profileImg',$my_picName);
      }
        //Userテーブルのログインアカウントレコードのmy_picカラムの値を$my_picNameに変更する
        $item = \App\User::where('id', Auth::user()->id)->first();
        $item->my_pic= $my_picName;
        $item->save();
        return redirect()->route('profile');


     //これでもOK
     //$uploadfile = $request->file('my_pic');
     // if(!empty($uploadfile)){
     //   $my_picName = $request->file('my_pic')->hashName();
     //   $request->file('my_pic')->storeAs('public/profileImg',$my_picName);
     //   $param = [
     //       'my_pic'=>$my_picName,
     //   ];
     // }
     //   User::where('id',$request->id)->update($param);
//
     //   return redirect()->route('profile');
//

        //これでもOK
        //$upload_image = $request->file('my_pic');
//
        //if($upload_image) {
		//	//アップロードされた画像を保存する
        //    $path = $upload_image->store('public/profileImg');
        //    //$path_name=Auth::id();
        //    //$path = $upload_image->storeAs('public/profileImg',Auth::id() . '.jpg');
        //    
        //        //User::where('id', 'Auth::user()->my_pic')->update(['my_pic' => $path]);
        //        //$item = User::where('id', $user->my_pic)->first();
        //        $item = User::where('id', Auth::user()->my_pic)->first();
        //        $item->my_pic = $path;
        //        $item->save();
		//	
		//}
        //return redirect()->route('profile');

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
