<?php

namespace App\Http\Controllers;

//下記を追加する
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//下記を追加する
use App\Photo;
use App\Image;
use App\Pin;

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
        $pins = Pin::with('user')->get();
        return view('home', [ 'pins' => $pins]);
    }

    public function upload(Request $request)
    {
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

            return view('home')->with('filename', basename($path));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors();
        }
    }

}