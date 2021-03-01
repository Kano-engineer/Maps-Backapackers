<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Photo;
use App\Image;
use App\Pin;
use App\Comment;

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
        $user_id = Auth::id();
        // comment = self-introduction in sidebar
        $comment=Comment::whereProfile_id($user_id)->get();
        $pins = Pin::with('user')->with('photos')->get();

        return view('home', [ 'pins' => $pins, 'comment'=>$comment]);
    }

    public function map()
    {
        
        $pins = Pin::with('user')->get();
        return view('map', [ 'pins' => $pins]);
    }

    public function map2()
    {
        $pins = Pin::with('user')->get();
        return view('map2', [ 'pins' => $pins]);
    }

    public function map3()
    {
        $pins = Pin::with('user')->get();
        return view('map3', [ 'pins' => $pins]);
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => [
                'required',
                'file',
                'image',
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