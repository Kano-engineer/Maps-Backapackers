<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TargetController extends Controller
{

    public function index(){
        return view('post.target_index');
    }
}
