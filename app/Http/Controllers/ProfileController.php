<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Image;

class ProfileController extends Controller
{
    //
    public function input()
    {
        return view('image.input');
    }

    public function upload(Request $request)
    {
        $this->validate($request, 
        [
            'file' => 
            // 必須
            'required',
            // アップロードされたファイルであること
            'file',
            // 画像ファイルであること
            'image',
            // MIMEタイプを指定
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
        //     return redirect('/output');
        // } else {
        //     return redirect()
        //         ->back()
        //         ->withInput()
        //         ->withErrors();
        }
    }

    public function output() {
        $user_id = Auth::id();
        $user_images = Image::whereUser_id($user_id)->get();
        return view('profile', ['user_images' => $user_images]);
    }

    public function destroy($id) {
            
        $pin=Image::where('id',$id);
        $pin->delete();
        return redirect()->back();
    }
}