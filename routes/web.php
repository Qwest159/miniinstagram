<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Profil_persoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    Route::get('/posts', [PostController::class, 'index'])->name('front.posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('front.posts.show');
    Route::get('/profil', [Profil_persoController::class, 'index'])->name('profil_perso.index');
    Route::get('/profil/{id}', [Profil_persoController::class, 'show'])->name('profil_perso.show');
});

require __DIR__ . '/auth.php';
