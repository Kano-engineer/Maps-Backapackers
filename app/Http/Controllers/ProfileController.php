<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileCommentRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Images;
use App\User;
use App\Pin;
use App\Comment;
use App\Photo;
// AWS S3
use Storage;
// Intervention Image
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    public function upload(ProfileImageRequest $request)
    {
        $validated = $request->validated();

        if ($request->file->isValid([])) {
            // S3アップロード
            $file = $request->file('file');

            \Tinify\setKey("Bb8c926D3P53vKYKs3y3R79phzvJvzxG");
            //TinyPNG Compress Image
            $source = \Tinify\fromFile($file);
            $source->toFile($file);

            $path = Storage::disk('s3')->putFile('/map', $file);

            $file_name = basename($path);
            $user_id = Auth::id();
            $new_image_data = new Images();

            $new_image_data->path = Storage::disk('s3')->url($path);;

            $new_image_data->user_id = $user_id;
            $new_image_data->file_name = $file_name;

            $new_image_data->save();

            return redirect()->back();
        }
    }

    public function create(Request $request) {
        // S3アップロード
        $media = $request->file('file');

        $path = Storage::disk('s3')->putFile('/map', $media,'public');
        $url = Storage::disk('s3')->url($path);
        dd($url);
    }

    public function index() {
        $user_id = Auth::id();
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Images::whereUser_id($user_id)->get();
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
    
    // profile2：UI/UX 分析
    public function index2() {
        $user_id = Auth::id();
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Images::whereUser_id($user_id)->get();
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
        $pin=Images::where('id',$id);
        $pin->delete();
        return redirect()->back();
    }

    public function show($id) {
        $user = User::find($id);
        $user_id = $id;
        $comments=Comment::whereProfile_id($user_id)->get();
        $user_images = Images::whereUser_id($user_id)->get();
        $pin = Pin::whereUser_id($user_id)->get();

        // reverse
        $pin = $pin->reverse();

        // map
        $pins = Pin::whereUser_id($user_id)->with('photos')->get();
        
        return view('profile', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
    }

        public function comment(ProfileCommentRequest $request,$id)
        {
            $validated = $request->validated();

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
            $user_images = Images::whereUser_id($user_id)->get();
            $pin = Pin::whereUser_id($user_id)->get();
    
            // reverse
            $pin = $pin->reverse();
    
            // map
            $pins = Pin::whereUser_id($user_id)->with('photos')->get();
            
            return view('follow', ['pins' => $pins,'user_images' => $user_images,'pin' => $pin,'user' => $user,'comments'=>$comments]);
        }
}