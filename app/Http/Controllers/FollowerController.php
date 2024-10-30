<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    function followerfollowed(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user_follower = Auth::user()->id;
        $user_followed = $user->id;
        if ($user_followed !== $user_follower) {
            $follower_exist = $user->follower()->where('follower_id', '=', $user_follower)
                ->first();
            if ($follower_exist !== null) {
                $follower_exist->delete();
            } else {
                $follow = $user->follower()->make();
                $follow->follower_id = $user_follower;
                $follow->followed_id = $user_followed;
                $follow->save();
            }
        }

        return redirect()->back();
    }


    static function follower($user_connecter, $user) {}
}
