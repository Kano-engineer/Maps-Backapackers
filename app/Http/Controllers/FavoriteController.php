<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Pin;

class FavoriteController extends Controller
{

    public function store(Pin $pin)
    {
        $pin->users()->attach(Auth::id());
        return redirect()->back();
    }

    public function destroy(Pin $pin)
    {
        $pin->users()->detach(Auth::id());
        return redirect()->back();
    }

    
}
