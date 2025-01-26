<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminNewsController;
use App\Http\Controllers\AdminTransportController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin', 'notifications', 'cart'])->prefix('admin')->name('admin.')->group(function () {
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
