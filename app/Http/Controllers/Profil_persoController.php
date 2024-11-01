<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Profil_persoController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $posts = Post::query()
            ->where('user_id', $user->id) // Récupère uniquement les posts de l'utilisateur authentifié
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%');
            })
            ->orderByDesc('updated_at')
            ->paginate(12);


        return view('profil_perso.index', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $posts = Post::query()

            ->where('user_id', $user->id)
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%');
            })
            ->orderByDesc('posts.updated_at')
            ->paginate(12);

        return view('profil_perso.show', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }
}
