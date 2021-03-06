<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ValidationRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\UpdateRequest;
use App\Comment;
use App\Images;
use App\Photo;
use App\User;
use App\Pin;
// AWS S3
use Storage;

class PinController extends Controller
{
    public function post(ValidationRequest $request)
    {
        $validated = $request->validated();

        // LastInsertID
        $data = Pin::create(
            [
                'text' => $request->text,
                'body' => $request->body,
                'location' => $request->location,
                'user_id' => $user_id = Auth::id(),
            ]);
        
        if ($request->hasFile('file')) {

            $file = $request->file;

            // S3
            // $file = $request->file('file');
            
            \Tinify\setKey("Bb8c926D3P53vKYKs3y3R79phzvJvzxG");
            //TinyPNG Compress Image
            $source = \Tinify\fromFile($file);
            $source->toFile($file);
            
            // S3
            // $path = Storage::disk('s3')->putFile('/map', $file);

            $path = $file->store('public');

            $file_name = basename($path);
            // LastInsertID
            $pin_id = $data->id;
            $new_image_data = new Photo();
            $new_image_data->path = Storage::disk('s3')->url($path);;

            $new_image_data->pin_id = $pin_id;
            $new_image_data->photo = $file_name;
            $new_image_data->save();
        }
        return redirect(route('home'));

        $user_id = Auth::id();
        // comment = self-introduction in sidebar
        $comment=Comment::whereProfile_id($user_id)->get();
        $pins = Pin::with('user')->with('photos')->get();
        // $user->favorites
        $id = $user_id;
        $user = User::find($id);

        $pins = $pins->reverse();

        // map
        $pin = Pin::with('user')->with('photos')->get();

        return view('home', [ 'pin' => $pin, 'pins' => $pins, 'comment'=>$comment,'user' => $user]);
    }

    public function show($id)
    {
        // HACK:only::with→find/where($id) otherwise show will not be executed correctly
        $pin = Pin::with('user')->get();
        $comments = comment::with('user')->get();
        // ↓
        $pin = Pin::find($id);        
        $comments = Comment::where('Pin_id',$id)->get();
        $photos = Photo::where('Pin_id',$id)->get();

        // comment = self-introduction in sidebar
        $user_id = Auth::id();
        $comment=Comment::whereProfile_id($user_id)->get();

        return view('pin',['pin' => $pin,'photos' => $photos,'comments'=>$comments,'comment'=>$comment]);
    }

    public function destroy($id) {
        $pin=Pin::where('id',$id);
        $pin->delete();

        return redirect('/home');
    }

    public function edit($id)
    {
        $user_id = Auth::id();
        // comment = self-introduction in sidebar
        $comment=Comment::whereProfile_id($user_id)->get();
        $pin = Pin::find($id);

        $this->authorize('edit', $pin); // Policy

        return view('edit',['pin' => $pin]);
    }

    public function update(UpdateRequest $request,$id)
    {
        $validated = $request->validated();

        if ($request->file('file')) {
            $file = $request->file;

            // S3
            // $file = $request->file('file');
            
            \Tinify\setKey("Bb8c926D3P53vKYKs3y3R79phzvJvzxG");
            //TinyPNG Compress Image
            $source = \Tinify\fromFile($file);
            $source->toFile($file);
            
            // S3
            // $path = Storage::disk('s3')->putFile('/map', $file);

            $path = $file->store('public');

            $file_name = basename($path);
            $pin_id = $id;
            $new_image_data = new Photo();
            
            $new_image_data->path = Storage::disk('s3')->url($path);;

            $new_image_data->pin_id = $pin_id;
            $new_image_data->photo = $file_name;
            $new_image_data->save();
        }

        $pin = Pin::find($id);
        $pin->text=$request->text;
        $pin->body=$request->body;
        $pin->save();

        return redirect(route('pin',$id));
    }

    public function comment(CommentRequest $request,$id)
    {
        $validated = $request->validated();

        Comment::create(
            [
                'comment' => $request->comment,
                'pin_id' => $id,
                'user_id' => $user_id = Auth::id(),
            ]);
        return redirect()->back();
    }

    public function destroyComment($id) {
        $comment=Comment::where('id',$id);
        $comment->delete();

        return redirect()->back();
    }

    public function DestryPhoto($id) {
        $photo=Photo::where('id',$id);
        $photo->delete();

        return redirect()->back();
   }
}