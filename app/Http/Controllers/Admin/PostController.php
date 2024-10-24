<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $Posts = Post::orderByDesc('updated_at')
            ->paginate(10);

        return view(
            'admin.posts.index',
            [
                'posts' => $Posts,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Post::class);
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        Gate::authorize('create', Post::class);
        // On crée un nouvel Post
        $post = Post::make();

        // On ajoute les propriétés du post
        $post->body = $request->validated()['body'];
        $post->user_id = Auth::id();


        // Si il y a une image, on la sauvegarde
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('posts', 'public');
            $post->img_path = $path;
        }




        // On sauvegarde le post en base de données
        $post->save();

        return redirect()->route('front.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $Post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->body = $request->validated()['body'];

        // Si il y a une image, on la sauvegarde
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('posts', 'public');
            $post->img_path = $path;
        }

        // On sauvegarde les modifications en base de données
        $post->save();
        return redirect()->route('front.posts.index');
        // return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return redirect()->back();
    }
}
