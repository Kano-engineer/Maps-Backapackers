<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\IndexRequest;
use App\Photo;
use App\Image;
use App\Pin;
use App\Comment;
use App\User;

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
        // $user->favorites
        $id = $user_id;
        $user = User::find($id);

        // reverse
        $pins = $pins->reverse();

        // map
        $pin = Pin::with('user')->with('photos')->get();
        
        return view('home', [ 'pin' => $pin, 'pins' => $pins, 'comment'=>$comment,'user' => $user]);
    }

    public function form()
    {
        return view('form');
    }

    public function search(Request $request)
    {
        // $validated = $request->validated();

        if($request->has('keyword')){
            $this->validate($request,
        [
            'keyword' => 'required',
        ],
        [
            'keyword.required' => 'キーワードは必須です。',
        ]
        );}

        if($request->has('keyword2')){
            $this->validate($request,
        [
            'keyword2' => 'required',
        ],
        [
            'keyword2.required' => '都道府県名は必須です。',
        ]
        );}
        
        $keyword = $request->input('keyword');
        $keyword2 = $request->input('keyword2');

        $query = Pin::query();
        $query2 = Pin::query();
        $query3 = User::query();

        if (!empty($keyword)) {
            $query->where('text', 'LIKE', "%{$keyword}%")
            ->orWhere('body', 'LIKE', "%{$keyword}%")
            ->orWhere('location', 'LIKE', "%{$keyword}%");

            $query2->where('text', 'LIKE', "%{$keyword}%")
            ->orWhere('body', 'LIKE', "%{$keyword}%")
            ->orWhere('location', 'LIKE', "%{$keyword}%");
            
            $query3->where('name', 'LIKE', "%{$keyword}%");
        }

        if (!empty($keyword2)) {
            $query->where('text', 'LIKE', "%{$keyword2}%")
            ->orWhere('body', 'LIKE', "%{$keyword2}%")
            ->orWhere('location', 'LIKE', "%{$keyword2}%");

            $query2->where('text', 'LIKE', "%{$keyword2}%")
            ->orWhere('body', 'LIKE', "%{$keyword2}%")
            ->orWhere('location', 'LIKE', "%{$keyword2}%");
            
            $query3->where('name', 'LIKE', "%{$keyword2}%");
        }
        // map
        $pins = $query->get();
        $pin = $query2->get();
        $user = $query3->get();
 

        return view('index2', compact('pins','pin','user'));
    }
}