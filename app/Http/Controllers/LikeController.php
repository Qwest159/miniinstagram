<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /////// LIKE   /////////

    function addandremoveLike(Request $request, Post $post)
    {

        $user_id = Auth::user()->id;
        $post_id = $post->id;
        // $commentId = $request->input('comment_id');
        $like_exist = $post->likes()->where('user_id', '=', $user_id)
            ->where('post_id', '=', $post_id)
            ->first();

        if ($like_exist !== null) {
            $like_exist->delete();
        } else {
            $like = $post->likes()->make();
            $like->user_id = $user_id;
            $like->save();
        }
        return redirect()->back();
    }
}
