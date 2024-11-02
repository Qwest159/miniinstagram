<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    // function pour ajouter ou retirer un j'aime
    function addandremoveLike(Request $request, Post $post)
    {

        $user_id = Auth::user()->id;
        $post_id = $post->id;
        // $commentId = $request->input('comment_id');


        $like_exist = $post->likes()->where('user_id', '=', $user_id)
            ->where('post_id', '=', $post_id)
            ->first();

        //si like_exist => supprimer ou sinon, enregistre-le
        if ($like_exist) {
            $like_exist->delete();
        } else {
            $like = $post->likes()->make();
            $like->user_id = $user_id;
            $like->save();
        }
        return redirect()->back();
    }

    // static function liker($user_connecter)
    // {
    //     Like::query()
    //         ->where("user_id", "=", $user_connecter)
    //         ->exists();
    // }
}
