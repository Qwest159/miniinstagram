<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Profil_persoController extends Controller
{
    public function index(Request $request)
    {
        // $user_id = Auth::id();
        $posts = Post::query()
            // ->join('users', 'users.id', '=', 'posts.user_id')
            // ->where('users.id', '=', $user_id)
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%')
                    // ->orWhere('title', 'LIKE', '%' . $request->query('search') . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->query('search') . '%');
                    })
                ;
            })
            ->orderByDesc('posts.updated_at')
            ->paginate(12);

        return view('profil_perso.index', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('profil_perso.show', [
            'post' => $post,
        ]);
    }
}
