<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $usersALL = User::select('id', 'name', 'biography', 'avatar_path')->get();
        $user = Auth::user();
        $posts = Post::query()
            // ->where('created_at', '<', now())
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')
                    // ->orWhere('title', 'LIKE', '%' . $request->query('search') . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->orderByDesc('updated_at')
            ->paginate(12);


        $userALL = [];
        if ($request->query('search')) {
            $userALL = User::where('name', 'LIKE', '%' . $request->query('search') . '%')->get();
        }
        // $liker = LikeController::liker($user);

        return view('front.posts.index', [
            'posts' => $posts,
            'user' => $user,
            'userALL' => $userALL,
            // 'liker' => $liker,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post
            ->comments()
            ->with('user')
            ->orderBy('created_at')
            ->get();
        return view('front.posts.show', [
            'post' => $post,
            'comments' => $comments,

        ]);
    }
    ///////COMMENTS///////
    public function addComment(Request $request, Post $post)
    {
        // On vérifie que l'utilisateur est authentifié
        $request->validate([
            'body' => 'required|string|max:300',
        ]);

        // On crée le commentaire
        $comment = $post->comments()->make();
        // On remplit les données
        $comment->body = $request->input('body');
        $comment->user_id = Auth::user()->id;
        // On sauvegarde le commentaire
        $comment->save();

        // On redirige vers la page de l'post
        return redirect()->back();
    }
    public function deleteComment(Post $post, Comment $comment)
    {
        // On vérifie que l'utilisateur à le droit de supprimer le commentaire
        Gate::authorize('delete', $comment);

        // On supprime le commentaire
        $comment->delete();

        // On redirige vers la page de l'post
        return redirect()->back();
    }
}
