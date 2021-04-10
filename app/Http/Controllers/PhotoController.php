<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Photo;
// AWS S3
use Storage;

class PhotoController extends Controller
{
    //
    public function upload(Request $request,$id)
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
                'file.required' => 'Photoは必須です。',  
            ]
        );
        
        if ($request->file('file')->isValid([])) {
            
            $path = $request->file->store('public');

            // $file = $request->file('file');
            // Storage::disk('s3')->putFile('/', $file);

            $file_name = basename($path);
            $pin_id = $id;
            $new_image_data = new Photo();
            $new_image_data->pin_id = $pin_id;
            $new_image_data->photo = $file_name;
            $new_image_data->save();

            return redirect()->back();
        }
    }

        public function destroy($id) {
            $photo=Photo::where('id',$id);
            $photo->delete();

            return redirect()->back();
    }

}