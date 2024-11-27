<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Comment;
use App\Models\Follower;
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
        //pour la recherche et disposition des posts classique
        $user = Auth::user();
        $posts = Post::query()
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')

                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->orderByDesc('updated_at')
            ->get();

        // affichage des posts des personnes suivies
        $i_followed = Post::query()->select('posts.id', 'posts.body', 'posts.img_path', 'posts.user_id', 'posts.updated_at')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('followers', 'users.id', '=', 'followers.followed_id')
            ->where('follower_id', "=", $user->id)
            ->orderByDesc('updated_at')
            ->get();


        // recup les id des post.id des abonnés, pour éviter un doublon de post pour likers
        $follows_post_id = Post::query()
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('followers', 'users.id', '=', 'followers.followed_id')
            ->where('follower_id', "=", $user->id)
            ->pluck('posts.id')
            ->toArray();


        // nombre de like trié du + au - sans doublons avec les peronnes suivies
        $likers = Post::query()->select('posts.id', 'posts.body', 'posts.img_path', 'posts.user_id', 'posts.updated_at', DB::raw('count(likes.id) as numbers_of_likes'))

            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')

                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->whereNotIn('posts.id', $follows_post_id)
            ->leftJoin('likes', 'likes.post_id', '=', 'posts.id')
            ->groupBy('posts.id')
            ->orderByDesc('numbers_of_likes')
            ->paginate(5);

        // affichage des utilisateurs pour le mettre dans un tableau
        $userALL = [];
        if ($request->query('search')) {
            $userALL = User::select('id', 'name', 'biography', 'avatar_path')
                ->where('name', 'LIKE', '%' . $request->query('search') . '%')
                ->get();
        }


        return view('front.posts.index', [
            'posts' => $posts,
            'user' => $user,
            'userALL' => $userALL,
            'i_followed' => $i_followed,
            'likers' => $likers,

        ]);
    }

    // function pour montrer la vue détaillée du post avec le commentaire
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post
            ->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
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
