<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Pin;
use App\Image;
use App\Photo;

class PinController extends Controller
{
    //
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
        $pin = Pin::find($id);
        $photos = Photo::where('Pin_id',$id)->get();
        return view('pin',['pin' => $pin,'photos' => $photos]);
    }

    public function destroy($id) {
            
        $pin=Pin::where('id',$id);
        $pin->delete();
        return redirect('/home');
    }

    public function edit($id)
    {
        $pin = Pin::find($id);
        return view('edit', compact('pin'));
    }

    public function update(Request $request)
    {

        // dd($request);

        $article = Pin::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $article->fill($form)->save();

        $pin = Pin::find($request->id);
        return view('pin',['pin' => $pin]);
    }

}