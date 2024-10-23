<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
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

        return view('front.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('front.posts.show', [
            'post' => $post,
        ]);
    }
}
