<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;

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
// Route::get('/accueil', function () {
//     return view('accueil');
// })->middleware(['auth', 'verified'])->name('accueil');

Route::get('/posts', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('front.posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts', [PostController::class, 'index'])->name('front.posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('front.posts.show');
});

require __DIR__ . '/auth.php';
