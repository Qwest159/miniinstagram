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
            ->paginate(12);


        // id des personne suivi
        $personne_que_jaisuivi = Post::query()->select('posts.id', 'posts.body', 'posts.img_path', 'posts.user_id', 'posts.updated_at')
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')

                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('followers', 'users.id', '=', 'followers.followed_id')
            ->where('follower_id', "=", $user->id)
            ->orderByDesc('updated_at')
            ->paginate(12);


        // nombre de like du + au -
        $liker = Post::query()->select('posts.id', 'posts.body', 'posts.img_path', 'posts.user_id')
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')

                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->leftJoin('likes', 'likes.post_id', '=', 'posts.id')
            ->groupBy('posts.id')
            ->orderByDesc(DB::raw('COUNT(likes.id)'))
            ->paginate(12);



        $tableaux = [1, 2, 3];
        // juste faire une addition de ces deux id qui sont les meme puis afficher les post



        // $groupedPosts = Post::select('user_id', 'category_id', DB::raw('COUNT(*) as post_count'))
        // ->groupBy('user_id', 'category_id')
        // ->orderBy('user_id')
        // ->orderBy('category_id')
        // ->get();






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
            'personne_que_jaisuivi' => $personne_que_jaisuivi,
            'liker' => $liker,
            'tableaux' => $tableaux,
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
