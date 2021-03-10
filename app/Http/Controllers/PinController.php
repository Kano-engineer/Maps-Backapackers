<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;
use App\Image;
use App\Photo;
use App\User;
use App\Pin;

class PinController extends Controller
{
    public function post(Request $request)
    {
        $this->validate($request,
            [
                'text' => 'required|string|max:30',
            ],
            [
                'text.required' => 'Placeは必須です。',
                'text.string'   => 'Placeには文字列を入力してください。',
                'text.max'      => 'Placeは30文字以下です。',
            ]
        );

        // LastInsertID
        $data = Pin::create(
            [
                'text' => $request->text,
                'body' => $request->body,
                'user_id' => $user_id = Auth::id(),
            ]);
        
        if ($request->hasFile('file')) {
            $path = $request->file->store('public');

            $file_name = basename($path);
            // LastInsertID
            $pin_id = $data->id;
            $new_image_data = new Photo();
            $new_image_data->pin_id = $pin_id;
            $new_image_data->photo = $file_name;
            $new_image_data->save();
        }

        $user_id = Auth::id();
        // comment = self-introduction in sidebar
        $comment=Comment::whereProfile_id($user_id)->get();
        $pins = Pin::with('user')->with('photos')->get();
        // $user->favorites
        $id = $user_id;
        $user = User::find($id);

        $pins = $pins->reverse();

        return view('home', [ 'pins' => $pins, 'comment'=>$comment,'user' => $user]);
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
        return view('edit',['pin' => $pin]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,
            [
                'text' => 'required|string|max:30',
            ],
            [
                'text.required' => 'Placeは必須です。',
                'text.string'   => 'Placeには文字列を入力してください。',
                'text.max'      => 'Placeは30文字以下です。',
            ]
    );
        $pin = Pin::find($id);
        $pin->text=$request->text;
        $pin->save();
        $photos = Photo::where('Pin_id',$id)->get();
        $comments = comment::with('user')->get();
        $comments = Comment::where('Pin_id',$id)->get();

        return view('pin',['pin' => $pin,'photos' => $photos,'comments'=>$comments]);
    }

    public function comment(Request $request,$id)
    {
        $this->validate($request,
            [
                'comment' => 'required|string|max:50',
            ],
            [
                'comment.required' => 'コメントは必須です。',
                'comment.string'   => 'テキストには文字列を入力してください。',
                'comment.max'      => 'テキストは50文字以下です。',
            ]
        );

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
}