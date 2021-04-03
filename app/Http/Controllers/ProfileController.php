<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Image;
use App\User;
use App\Pin;
use App\Comment;
use App\Photo;

class ProfileController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, 
            [
                'file' => 
                'required',
                'file',
                'image',
                'mimes:jpeg,png',
            ],
            [
                'file.required' => '写真は必須です。',
            ]
    );
        if ($request->file('file')->isValid([])) {
            $path = $request->file->store('public');

            $file_name = basename($path);
            $user_id = Auth::id();
            $new_image_data = new Image();
            $new_image_data->user_id = $user_id;
            $new_image_data->file_name = $file_name;

            $new_image_data->save();

            return redirect()->back();
        }
    }

    public function index() {
        $user_id = Auth::id();
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Image::whereUser_id($user_id)->get();
        $pin = Pin::whereUser_id($user_id)->with('photos')->get();
        // $user->favorites
        $id = $user_id;
        $user = User::find($id);

        // reverse
        $pin = $pin->reverse();

        // map
        $pins = Pin::whereUser_id($user_id)->with('photos')->get();

        return view('profile', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
    }
    
    // profile2：タブメニュー3つにする
    public function index2() {
        $user_id = Auth::id();
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Image::whereUser_id($user_id)->get();
        $pin = Pin::whereUser_id($user_id)->with('photos')->get();
        // $user->favorites
        $id = $user_id;
        $user = User::find($id);

        // reverse
        $pin = $pin->reverse();

        // map
        $pins = Pin::whereUser_id($user_id)->with('photos')->get();

        return view('profile2', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
    }

    public function destroy($id) {
        $pin=Image::where('id',$id);
        $pin->delete();
        return redirect()->back();
    }

    public function show($id) {
        $user = User::find($id);
        $user_id = $id;
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Image::whereUser_id($user_id)->get();
        $pin = Pin::whereUser_id($user_id)->get();

        // reverse
        $pin = $pin->reverse();

        // map
        $pins = Pin::whereUser_id($user_id)->with('photos')->get();
        
        return view('profile', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
    }

        public function comment(Request $request,$id)
        {
            $this->validate($request,
                [
                    'comment_profile' => 'required|string|max:50',
                ],
                [
                    'comment_profile.required' => '自己紹介は必須です。',
                    'comment_profile.string'   => '自己紹介には文字列を入力してください。',
                    'comment_profile.max'      => '自己紹介は50文字以下です。',
                ]
            );

            Comment::create(
                [
                'comment' => $request->comment_profile,
                'profile_id' => $id,
                ]);
            return redirect()->back();
        }
        public function destroyComment($id) {
            $comment=Comment::where('id',$id);
            $comment->delete();
            
            return redirect()->back();
        }

        // フォロー
        public function follow($id) {
            $user = User::find($id);
            $user_id = $id;
            $comments=Comment::whereProfile_id($user_id)->get();
            $user_images = Image::whereUser_id($user_id)->get();
            $pin = Pin::whereUser_id($user_id)->get();
    
            // reverse
            $pin = $pin->reverse();
    
            // map
            $pins = Pin::whereUser_id($user_id)->with('photos')->get();
            
            return view('follow', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
        }
}