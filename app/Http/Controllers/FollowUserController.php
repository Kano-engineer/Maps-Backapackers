<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\FollowUser;

class FollowUserController extends Controller
{
    public function follow(User $user) {
        $follow = FollowUser::create([
            'following_user_id' => \Auth::user()->id,
            'followed_user_id' => $user->id,
        ]);

        return redirect()->back();

        // $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());
        // return response()->json(['followCount' => $followCount]);
    }

    public function unfollow(User $user) {
        $follow = FollowUser::where('following_user_id', \Auth::user()->id)->where('followed_user_id', $user->id)->first();
        $follow->delete();

        return redirect()->back();

        // $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());
        // return response()->json(['followCount' => $followCount]);
    }
}