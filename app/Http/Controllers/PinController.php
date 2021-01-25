<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Image;
use App\Photo;
use App\Pin;
use App\Comment;

class PinController extends Controller
{
    public function post(Request $request)
    {
        $this->validate($request,
            [
                'text' => 'required|string|max:30',
            ],
            [
                'text.required' => 'テキストは必須です。',
                'text.string'   => 'テキストには文字列を入力してください。',
                'text.max'      => 'テキストは30文字以下です。',
            ]
        );

        Pin::create(
            [
            'text' => $request->text,
            'user_id' => $user_id = Auth::id(),
            ]);
        return redirect()->back();
    }

    public function show($id)
    {
        // withメソッド→find/where($id)でないと通らない。
        $pin = Pin::with('user')->get();
        $comments = comment::with('user')->get();

        $pin = Pin::find($id);        
        $comments = Comment::where('Pin_id',$id)->get();
        $photos = Photo::where('Pin_id',$id)->get();

        return view('pin',['pin' => $pin,'photos' => $photos,'comments'=>$comments]);
    }

    public function destroy($id) {
            
        $pin=Pin::where('id',$id);
        $pin->delete();
        return redirect('/home');
    }

    public function edit($id)
    {
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
            'text.required' => 'テキストは必須です。',
            'text.string'   => 'テキストには文字列を入力してください。',
            'text.max'      => 'テキストは30文字以下です。',
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

    // コメント
    public function comment(Request $request,$id)
    {
        // dd($request,$id);

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