<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.main');
    })->name('dashboard');
});
Route::get('/videos/{id}',[VideoContoller::class,'show']);
Route::resource('/videos',VideoContoller::class)->middleware('auth')->except(['show']);
Route::get('/video/search',[VideoContoller::class,'search'])->name('video.search');
Route::post('/like',[LikeController::class,'likeVideo'])->name('like');
