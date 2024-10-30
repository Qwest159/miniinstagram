<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Follower;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('no_connect');
});


//ADMIN
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('/posts', AdminPostController::class);
    // Gestion des utilisateurs (Détails et changement de rôle)
    Route::resource('/users', UserController::class);
});

Route::get('/posts', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('front.posts.index');

Route::middleware('auth')->group(function () {


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar/edit', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    // profil_perso
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');


    //post
    Route::get('/posts', [PostController::class, 'index'])->name('front.posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('front.posts.show');


    // comments
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('front.posts.comments.add');
    // Suppression d'un commentaire
    Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'deleteComment'])->name('front.posts.comments.delete');

    // like //

    Route::post('/posts/{post}/likes', [LikeController::class, 'addandremoveLike'])->name('front.posts.likes.addandremove');

    // Abonné
    Route::post('/profile/{id}/follower', [FollowerController::class, 'followerfollowed'])->name('profile.follower');
});

require __DIR__ . '/auth.php';
