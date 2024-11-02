<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    // function pour follow ou unfollow l'utilisateur
    function followerfollowed(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user_follower = Auth::user()->id;
        $user_followed = $user->id;

        // évite de follow soi-mêmes
        if ($user_followed !== $user_follower) {
            $follower_exist = $user->follower()->where('follower_id', '=', $user_follower)
                ->first();

            // existe=> delete ou pas existe=> enregistre le
            if ($follower_exist) {
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
