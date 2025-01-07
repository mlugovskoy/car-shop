<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminNewsController;
use App\Http\Controllers\AdminTransportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('/news', NewsController::class)
    ->name('index', 'news.index')
    ->name('show', 'news.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::post('/news/{id}', [NewsController::class, 'storeComment'])->name('news.store.comment');

Route::get('/transports/{section?}', [TransportController::class, 'index'])->name('transport.index');
Route::post('/transports/add_new_transport', [TransportController::class, 'store'])->name('transport.store');
Route::post('/transports/{section?}/add_favorite', [TransportController::class, 'addFavorite'])->name(
    'transport.addFavorite'
);
Route::post('/transports/{section?}/delete_favorite', [TransportController::class, 'removeFavorite'])->name(
    'transport.removeFavorite'
);
Route::get('/transports/{section?}/{id?}', [TransportController::class, 'show'])->name('transport.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/transports', [AdminTransportController::class, 'index'])->name('transports');
    Route::post('/transports/{id}', [AdminTransportController::class, 'update'])->name('transports.update');
    Route::delete('/transports/destroy/{id}', [AdminTransportController::class, 'destroy'])->name('transports.destroy');

    Route::get('/news', [AdminNewsController::class, 'index'])->name('news');
    Route::post('/news/{id}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/destroy/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
});


require __DIR__ . '/auth.php';
