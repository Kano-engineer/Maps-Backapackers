<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Photo;

class PhotoController extends Controller
{
    //
    public function upload(Request $request,$id)
    {

        // dd($id);

        $this->validate($request, [
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);
        
        if ($request->file('file')->isValid([])) {
            $path = $request->file->store('public');

            $file_name = basename($path);
            $pin_id = $id;
            $new_image_data = new Photo();
            $new_image_data->pin_id = $pin_id;
            $new_image_data->photo = $file_name;

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
        return view('image.output', ['user_images' => $user_images]);
    }
    //上記までを追記

}