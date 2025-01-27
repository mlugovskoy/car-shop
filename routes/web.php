<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['notifications', 'cart'])->group(function () {
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

    Route::post('/notifications', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');


    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');


    Route::get('/order', [OrderController::class, 'index'])->name('order');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
