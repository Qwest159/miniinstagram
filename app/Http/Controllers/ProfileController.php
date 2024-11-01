<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
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


        return view('profile.index', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }



    public function show(Request $request, $id)
    {
        $user_connecter = Auth::user()->id;
        $user = User::findOrFail($id);



        $follows = Follower::query()
            ->where('followed_id', "=", $user->id)
            ->where("follower_id", "=", $user_connecter)
            ->exists();
        // $follows = FollowerController::follower($user_connecter, $user);
        // ->first();

        // difference: exist retourne une booleen et ne transfere que les tables demandées
        // first va rechercher dans toutes les tables , meme ceux qui ne sont pas demandé
        // => gain performance


        $posts = Post::query()
            ->where('user_id', $user->id)
            ->when($request->query('search'), function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->query('search') . '%');
            })
            ->orderByDesc('posts.updated_at')
            ->paginate(12);

        return view('profile.show', [
            'posts' => $posts,
            'user' => $user,
            'follows' => $follows,
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        // Validation de l'image sans passer par une form request
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        // Si l'image est valide, on la sauvegarde
        if ($request->hasFile('avatar')) {
            $user = $request->user();
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
