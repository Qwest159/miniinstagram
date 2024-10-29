<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    function followerfollowed(Request $request, User $user)
    {
        $user_followed = $user->id;
        $user_follower = Auth::user()->id;

        $followed =


        // public function follower()
        // {
        //     return $this->hasMany(Follower::class, "followed_id");
        // }

        // public function followed()
        // {
        //     return $this->hasMany(Follower::class, "follower_id");
        // }
    }
}
