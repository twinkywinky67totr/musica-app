<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas públicas de álbumes
Route::resource('albums', AlbumController::class)->only(['index', 'show']);

// Rutas protegidas: solo usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::resource('albums', AlbumController::class)->except(['index', 'show']);
    Route::get('/create', [AlbumController::class, 'create'])->name('albums.create');
});


require __DIR__.'/auth.php';
